<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use App\Models\User;

class StockRequestController extends Controller
{
    public function index()
    {
        $stockRequests = StockRequest::with('user', 'stock')->get();
        return view('stock_requests.index', compact('stockRequests'));
    }

    public function create()
    {
        $stocks = Stock::all();
        return view('stock_requests.create', compact('stocks'));
    }

    public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'stock_ids' => 'required|array|min:1',
        'stock_ids.*' => 'required|string', // Ensure stock_id is provided for each item
        'requested_quantities' => 'required|array|min:1',
        'requested_quantities.*' => 'required|integer|min:1',
        'date' => 'required|date',
        'catatan' => 'nullable|string',
    ]);

    // Loop through each stock_id and create a stock request for each
    foreach ($request->stock_ids as $index => $stock_id) {
        StockRequest::create([
            'user_id' => auth()->id(),
            'stock_id' => $stock_id,  // User-defined stock_id
            'requested_quantity' => $request->requested_quantities[$index],
            'status' => 'pending',  // Default status is pending
            'catatan' => $request->catatan,
            'date' => $request->date,
        ]);
    }

    // Redirect back with a success message
    return redirect()->route('stock_requests.create')->with('success', 'Stock request submitted successfully.');
}
    
    public function showApprovalForm($id)
    {
        $stockRequest = StockRequest::with('stock', 'user')->findOrFail($id);
        $userStockRequests = StockRequest::with('stock')->where('user_id', $stockRequest->user_id)->get();

        return view('stock_requests.approve', compact('stockRequest', 'userStockRequests'));
    }

    public function approve(Request $request, $id)
    {
        $stockRequest = StockRequest::findOrFail($id);

        $request->validate([
            'approved_quantity' => 'required|integer|min:1|max:' . $stockRequest->requested_quantity,
        ]);

        $approvedQuantity = $request->input('approved_quantity');

        $stockRequest->approved_quantity = $approvedQuantity;
        $stockRequest->status = 'approved';
        $stockRequest->save();

        $stock = Stock::where('stock_id', $stockRequest->stock_id)->firstOrFail();
        $stock->decreaseQuantity($approvedQuantity); // Ensure this method exists in the Stock model

        return redirect()->route('stock_requests.index')->with('success', 'Stock request approved and stock quantity updated successfully.');
    }

    public function approveAll(Request $request)
    {
        $approvedQuantities = $request->input('approved_quantities'); // This should be an array

        foreach ($approvedQuantities as $requestId => $approvedQuantity) {
            $stockRequest = StockRequest::findOrFail($requestId);

            if ($stockRequest->status === 'approved') {
                continue; // Skip already approved stock requests
            }

            if ($approvedQuantity <= $stockRequest->requested_quantity) {
                $stockRequest->approved_quantity = $approvedQuantity;
                $stockRequest->status = 'approved';
                $stockRequest->save();

                $stock = Stock::where('stock_id', $stockRequest->stock_id)->firstOrFail();
                $stock->decreaseQuantity($approvedQuantity); // Ensure this method exists in the Stock model
            }
        }

        return redirect()->route('stock_requests.index')->with('success', 'All pending stock requests have been approved.');
    }

    public function reject($id)
    {
        $stockRequest = StockRequest::findOrFail($id);
        $stockRequest->status = 'rejected';
        $stockRequest->save();

        return redirect()->route('stock_requests.index')->with('success', 'Stock request rejected successfully.');
    }

    public function generateReport($userId)
    {
        $user = User::with('stockRequests.stock')->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        if ($user->stockRequests->isEmpty()) {
            return redirect()->back()->with('error', 'No stock requests available for this user.');
        }

        $pdf = FacadePdf::loadView('stock_requests.report', [
            'stockRequests' => $user->stockRequests,
            'user' => $user,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('user_stock_requests_report.pdf');
    }

    public function destroy($id)
    {
        $stockRequest = StockRequest::findOrFail($id);

        if ($stockRequest->status !== 'approved') {
            return redirect()->back()->withErrors('Only approved stock requests can be deleted.');
        }

        $stockRequest->delete();

        return redirect()->route('stock_requests.index')->with('success', 'Stock request deleted successfully.');
    }
}

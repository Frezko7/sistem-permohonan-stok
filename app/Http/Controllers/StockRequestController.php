<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Auth;

class StockRequestController extends Controller
{
    public function index()
    {
        // Use 'stock' instead of 'stock_id' to match the relationship method in the model
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
        $validatedData = $request->validate([
            'stock_ids' => 'required|array',
            'stock_ids.*' => 'exists:stocks,stock_id', // Make sure the foreign key is correct
            'requested_quantities' => 'required|array',
            'requested_quantities.*' => 'integer|min:1',
        ]);

        foreach ($request->stock_ids as $index => $stockId) {
            $requestedQuantity = $request->requested_quantities[$index];

            StockRequest::create([
                'user_id' => auth()->id(),
                'stock_id' => $stockId,
                'requested_quantity' => $requestedQuantity,
                'status' => 'pending',
                'catatan' => $request->input('catatan') ?? null,
            ]);
        }

        return redirect()->route('stock_requests.create')->with('success', 'Stock request submitted successfully!');
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

        $stock = Stock::findOrFail($stockRequest->stock_id);
        $stock->decreaseQuantity($approvedQuantity); // Ensure this method exists in the Stock model

        return redirect()->route('stock_requests.index')->with('success', 'Stock request approved and stock quantity updated successfully.');
    }

    public function approveAll(Request $request)
    {
        $approvedQuantities = $request->input('approved_quantities'); // This should be an array

        foreach ($approvedQuantities as $requestId => $approvedQuantity) {
            $stockRequest = StockRequest::findOrFail($requestId);

            // Skip already approved stock requests
            if ($stockRequest->status === 'approved') {
                continue; // Move to the next iteration
            }

            // Ensure the approved quantity is valid
            if ($approvedQuantity <= $stockRequest->requested_quantity) {
                $stockRequest->approved_quantity = $approvedQuantity;
                $stockRequest->status = 'approved';
                $stockRequest->save();

                // Update stock quantity if needed
                $stock = Stock::findOrFail($stockRequest->stock_id);
                $stock->decreaseQuantity($approvedQuantity); // Ensure this method exists in the Stock model
            }
        }

        return redirect()->route('stock_requests.index')->with('success', 'All pending stock requests have been approved.');
    }

    public function reject($id)
    {
        $stockRequest = StockRequest::findOrFail($id);
        $stockRequest->status = 'rejected'; // Set the status as rejected
        $stockRequest->save();

        return redirect()->route('stock_requests.index')->with('success', 'Stock request rejected successfully.');
    }

    public function generateReport($userId)
{
    // Fetch stock requests made by the specific user
    $stockRequests = StockRequest::with(['stock', 'user'])
        ->where('user_id', $userId)
        ->get();

    // Check if the user has made any stock requests
    if ($stockRequests->isEmpty()) {
        return redirect()->back()->with('error', 'No stock requests found for the selected user.');
    }

    // Generate the PDF with stock requests data
    $pdf = FacadePdf::loadView('stock_requests.report', [
        'stockRequests' => $stockRequests,
    ])->setPaper('a4', 'landscape');

    // Download the generated PDF
    return $pdf->download('stock_requests_by_user_' . $userId . '_report.pdf');
}

}

<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'requested_quantity' => 'required|integer',
            'catatan' => 'nullable|string|max:255',
        ]);

        StockRequest::create([
            'user_id' => Auth::id(),
            'stock_id' => $request->stock_id,
            'requested_quantity' => $request->requested_quantity,
            'catatan' => $request->catatan,
            'request_date' => $request->request_date, 
        ]);

        return redirect()->route('stock_requests.index')->with('success', 'Stock request submitted successfully.');
    }

    public function showApprovalForm($id)
    {
        $stockRequest = StockRequest::with('stock', 'user')->findOrFail($id);
        return view('stock_requests.approve', compact('stockRequest'));
    }



    public function approve(Request $request, $id)
    {
        $stockRequest = StockRequest::findOrFail($id);

        // Validate that approved_quantity is required and does not exceed requested_quantity
        $request->validate([
            'approved_quantity' => 'required|integer|min:1|max:' . $stockRequest->requested_quantity,
        ]);

        $approvedQuantity = $request->input('approved_quantity');

        // Set the approved quantity and status
        $stockRequest->approved_quantity = $approvedQuantity;
        $stockRequest->status = 'approved';
        $stockRequest->save();

        // Update the stock quantity based on approved quantity
        $stock = Stock::findOrFail($stockRequest->stock_id);
        $stock->decreaseQuantity($approvedQuantity); // Decrease based on approved quantity

        return redirect()->route('stock_requests.index')->with('success', 'Stock request approved and stock quantity updated successfully.');
    }

    public function reject($id)
    {
        $stockRequest = StockRequest::findOrFail($id);

        // Change the status of the stock request
        $stockRequest->status = 'rejected'; // Set the status as rejected
        $stockRequest->save();

        return redirect()->route('stock_requests.index')->with('success', 'Stock request rejected successfully.');
    }
}

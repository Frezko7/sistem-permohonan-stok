<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
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
    $validatedData = $request->validate([
        'stock_ids' => 'required|array',
        'stock_ids.*' => 'exists:stocks,id',
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
        return view('stock_requests.approve', compact('stockRequest'));
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
        $stock->decreaseQuantity($approvedQuantity); // Make sure this method exists

        return redirect()->route('stock_requests.index')->with('success', 'Stock request approved and stock quantity updated successfully.');
    }

    public function reject($id)
    {
        $stockRequest = StockRequest::findOrFail($id);
        $stockRequest->status = 'rejected'; // Set the status as rejected
        $stockRequest->save();

        return redirect()->route('stock_requests.index')->with('success', 'Stock request rejected successfully.');
    }

    public function generateReportById($id)
{
    // Fetch the specific stock request by ID with its relationships
    $stockRequest = StockRequest::with(['stock', 'user'])->findOrFail($id);

    // Generate the PDF for the specific stock request
    $pdf = FacadePdf::loadView('stock_requests.report', [
        'stockRequest' => $stockRequest,
    ])->setPaper('a4', 'landscape');

    // Return the generated PDF for download
    return $pdf->download('stock_request_' . $stockRequest->id . '_report.pdf');
}
}

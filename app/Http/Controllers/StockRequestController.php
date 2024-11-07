<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Spatie\Browsershot\Browsershot;
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
            'request_date' => 'required|date', // Add validation for request_date
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

    public function generateReport()
    {
        $stockRequests = StockRequest::with(['stock', 'user'])->get();

        $pdf = PDF::loadView('stock_requests.report', [
            'stockRequests' => $stockRequests,
        ]);

        return $pdf->download('stock_requests_report.pdf');
    }

    public function generatePdfReport()
    {
        // Load the view with data
        $stockRequests = StockRequest::with(['user', 'stock'])->get();
        $html = view('stock_requests.index', compact('stockRequests'))->render();

        // Generate PDF
        $pdfPath = storage_path('app/public/stock_requests_report.pdf'); // You can choose your preferred storage path

        Browsershot::html($html)
            ->setPaper('A4')
            ->save($pdfPath);

        return response()->download($pdfPath, 'stock_requests_report.pdf');
    }
}

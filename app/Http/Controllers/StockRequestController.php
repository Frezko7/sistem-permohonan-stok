<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use App\Models\User;
use Illuminate\Support\Str;

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
        $groupId = Str::uuid(); // Generate a unique ID for the group
    
        // Validate the request data
        $request->validate([
            'stock_ids' => 'required|array|min:1',
            'stock_ids.*' => 'required|numeric|distinct', // Ensure stock IDs are numbers
            'requested_quantities' => 'required|array|min:1',
            'requested_quantities.*' => 'required|integer|min:1', // Ensure quantities are integers
            'date' => 'required|date',
            'catatan' => 'nullable|string',
        ]);        
    
        $invalidStockIds = [];
        $exceededQuantities = [];
    
        // Validate each stock_id to ensure it exists in the database
        foreach ($request->stock_ids as $index => $stock_id) {
            $stock = Stock::where('stock_id', $stock_id)->first();
    
            if (!$stock) {
                $invalidStockIds[] = $stock_id;
            } elseif ($request->requested_quantities[$index] > $stock->quantity) {
                $exceededQuantities[] = [
                    'stock_id' => $stock_id,
                    'available_quantity' => $stock->quantity,
                    'requested_quantity' => $request->requested_quantities[$index]
                ];
            }
        }
    
        // If there are any invalid stock IDs or exceeded quantities, return an error
        if (!empty($invalidStockIds)) {
            return redirect()->back()
                ->withErrors(['stock_ids' => 'The following stock IDs are invalid: ' . implode(', ', $invalidStockIds)])
                ->withInput();
        }
    
        if (!empty($exceededQuantities)) {
            $exceededMessage = 'Permohonan stok gagal. Stok tidak mencukupi.';
            foreach ($exceededQuantities as $exceeded) {
                $exceededMessage .= "No. Kod: {$exceeded['stock_id']} (Mohon: {$exceeded['requested_quantity']}, Stok Sedia Ada: {$exceeded['available_quantity']}), ";
            }
            return redirect()->back()
                ->withErrors(['requested_quantities' => rtrim($exceededMessage, ', ')])
                ->withInput();
        }
    
        // Loop through each stock_id and create a stock request for each
        foreach ($request->stock_ids as $index => $stock_id) {
            StockRequest::create([
                'user_id' => auth()->id(),
                'stock_id' => $stock_id,
                'requested_quantity' => $request->requested_quantities[$index],
                'status' => 'pending',
                'catatan' => $request->catatan,
                'date' => $request->date,
                'group_id' => $groupId, // Save the same group_id for all requests
            ]);
        }
    
        return redirect()->route('stock_requests.create')
            ->with('success', 'Stock request submitted successfully.');
    }
    

public function showApprovalForm($id)
{
    $stockRequest = StockRequest::with('stock', 'user')->findOrFail($id);
    $userStockRequests = StockRequest::with('stock')
        ->where('user_id', $stockRequest->user_id)
        ->whereHas('stock') // Include only valid stock requests
        ->get();

    return view('stock_requests.approve', compact('stockRequest', 'userStockRequests'));
}

public function approve(Request $request, $id)
{
    $stockRequest = StockRequest::findOrFail($id);

    // Validate the approved quantity
    $request->validate([
        'approved_quantity' => 'required|integer|min:1|max:' . $stockRequest->requested_quantity,
        'date_approved' => 'required|date',
    ]);

    $approvedQuantity = $request->input('approved_quantity');
    $dateApproved = $request->input('date_approved');

    // Update the stock request
    $stockRequest->approved_quantity = $approvedQuantity;
    $stockRequest->date_approved = now(); // Record the approval date
    $stockRequest->status = 'approved';
    $stockRequest->save();

    // Update the stock quantity
    $stock = Stock::where('stock_id', $stockRequest->stock_id)->firstOrFail();
    $stock->decreaseQuantity($approvedQuantity); // Ensure this method is implemented in the Stock model

    return redirect()->route('stock_requests.index')->with('success', 'Stock request approved and stock quantity updated successfully.');
}

public function approveAll(Request $request)
{
    $approvedQuantities = $request->input('approved_quantities'); // Array of approved quantities

    foreach ($approvedQuantities as $requestId => $approvedQuantity) {
        $stockRequest = StockRequest::findOrFail($requestId);

        // Skip already approved stock requests
        if ($stockRequest->status === 'approved') {
            continue;
        }

        // Validate the approved quantity
        if ($approvedQuantity > 0 && $approvedQuantity <= $stockRequest->requested_quantity) {
            // Update the stock request
            $stockRequest->approved_quantity = $approvedQuantity;
            $stockRequest->date_approved = now(); // Record the approval date
            $stockRequest->status = 'approved';
            $stockRequest->save();

            // Update the stock quantity
            $stock = Stock::where('stock_id', $stockRequest->stock_id)->firstOrFail();
            $stock->decreaseQuantity($approvedQuantity); // Ensure this method is implemented in the Stock model
        }
    }

    return redirect()->route('stock_requests.index')->with('success', 'All pending stock requests have been approved.');
}

    public function reject($id)
{
    // Find the stock request by ID
    $stockRequest = StockRequest::findOrFail($id);

    // Get the group_id of the request
    $groupId = $stockRequest->group_id;

    // Update the status of all stock requests with the same group_id to 'rejected'
    StockRequest::where('group_id', $groupId)->update(['status' => 'rejected']);

    return redirect()->route('stock_requests.index')->with('success', 'All stock requests in the group have been rejected successfully.');
}

// Method to preview the report
public function viewReport($groupId)
{
    $stockRequests = StockRequest::where('group_id', $groupId)
        ->with(['user', 'stock'])
        ->get();

    return view('stock_requests.report', compact('stockRequests'));
}

public function generateReport($groupId)
{
    $stockRequests = StockRequest::with('stock', 'user')
        ->where('group_id', $groupId)
        ->get();

    if ($stockRequests->isEmpty()) {
        return redirect()->back()->with('error', 'No stock requests available for this group.');
    }

    // Retrieve the user (if applicable, from the first stock request or group context)
    $user = $stockRequests->first()->user;

    $pdf = FacadePdf::loadView('stock_requests.report', [
        'stockRequests' => $stockRequests,
        'groupId' => $groupId,
        'user' => $user, // Pass the user to the view
    ])->setPaper('a4', 'landscape');

    return $pdf->download('group_stock_requests_report.pdf');
}

public function showReceivedQuantityForm($groupId)
{
    // Fetch stock requests for the specified group ID, including related stock details
    $stockRequests = StockRequest::where('group_id', $groupId)
        ->with('stock')
        ->get();

    if ($stockRequests->isEmpty()) {
        return redirect()->route('stock_requests.index')->withErrors('Tiada stok untuk kemaskini.');
    }

    return view('stock_requests.receive', compact('stockRequests', 'groupId'));
}

public function updateReceivedQuantities(Request $request, $groupId)
{
    $validatedData = $request->validate([
        'received_name' => 'required|string',
        'received_quantities' => 'required|array',
        'received_quantities.*' => 'nullable|integer|min:0',
        'catatan' => 'nullable|string|max:255',
        'date_received' => 'nullable|date',
    ]);

    $stockRequests = StockRequest::where('group_id', $groupId)->get();

    foreach ($stockRequests as $stockRequest) {
        if (isset($validatedData['received_quantities'][$stockRequest->id])) {
            $receivedQuantity = $validatedData['received_quantities'][$stockRequest->id];

            if ($receivedQuantity > $stockRequest->approved_quantity) {
                return redirect()->back()->withErrors([
                    'received_quantities.' . $stockRequest->id => 'Kuantiti diterima tidak boleh melebihi kuantiti yang diluluskan.',
                ]);
            }

            $stockRequest->update([
                'received_name' => $request->input('received_name'),
                'received_quantity' => $receivedQuantity,
                'catatan' => $request->catatan,
                'date_received' => $request->date_received ?? now(),
            ]);
        }
    }

    return redirect()->route('dashboard')->with('success', 'Kuantiti diterima dan catatan berjaya dikemaskini.');
}

}

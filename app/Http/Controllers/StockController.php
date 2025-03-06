<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StockController extends Controller
{
    public function index(Request $request)
{
    $query = Stock::query();

    // Check if there is a search query
    if ($request->has('search')) {
        $query->where('description', 'like', '%' . $request->search . '%')
              ->orWhere('stock_id', 'like', '%' . $request->search . '%');
    }

    // Get filtered stocks or all stocks if no search query
    $stocks = $query->get();

    return view('stocks.index', compact('stocks'));
}

    public function create()
    {
        return view('stocks.create');
    }

    public function store(Request $request)
{
    // Validate the request, including the image
    $request->validate([
        'description' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Add image validation
    ]);

    // Handle image upload if present
    $imagePath = null;
    if ($request->hasFile('image')) {
        // Store the image in the 'public/images' directory
        $imagePath = $request->file('image')->store('images', 'public');
    }

    // Create the stock with the image path
    Stock::create([
        'description' => $request->description,
        'quantity' => $request->quantity,
        'image' => $imagePath, // Save the image path in the database
    ]);

    return redirect()->route('stocks.index')->with('success', 'Stok berjaya ditambah!');
}


    // Show edit form
    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        return view('stocks.edit', compact('stock'));
    }


    // Update stock
    public function update(Request $request, $id)
{
    // Validate the input data, including image (optional)
    $validatedData = $request->validate([
        'description' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image is now optional
    ]);

    // Find the stock by ID
    $stock = Stock::findOrFail($id);

    // Update the stock details
    $stock->description = $validatedData['description'];
    $stock->quantity = $validatedData['quantity'];

    // Handle image upload if a new image is uploaded
    if ($request->hasFile('image')) {
        // Check if there is an old image, and delete it if exists
        if ($stock->image) {
            $oldImagePath = 'public/' . $stock->image;
            if (Storage::exists($oldImagePath)) {
                Storage::delete($oldImagePath);  // Delete the old image
            }
        }

        // Store the new image in the 'public/images' directory
        $stock->image = $request->file('image')->store('images', 'public');
    }

    // Save the updated stock
    $stock->save();

    // Redirect with success message
    return redirect()->route('stocks.index')->with('success', 'Stok berjaya dikemaskini.');
}
    

    // Delete stock
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('stocks.index')->with('success', 'Stok berjaya dihapus.');
    }

    public function search(Request $request)
{
    $query = $request->input('query'); // Get the search query from the input

    // Ensure the query is not empty
    if (empty($query)) {
        return redirect()->back()->with('error', 'Please enter a search term.');
    }

    // Search for stock items by exact or partial description or stock ID
    $stocks = Stock::where(function ($q) use ($query) {
                        $q->where('description', '=', $query) // Exact match on description
                          ->orWhere('stock_id', '=', $query) // Exact match on stock ID
                          ->orWhere('description', 'LIKE', "%{$query}%"); // Partial match on description
                    })
                    ->get();

    // Return the view with the search results
    return view('catalog.index', compact('stocks', 'query'));
}
public function getStockDescription(Request $request)
{
    $stockId = $request->query('stock_id');
    
    if (!$stockId) {
        return response()->json(['error' => 'Stock ID is required'], 400);
    }

    // Query the stock based on the stock code (assuming you use 'stock_id' for unique identification)
    $stock = Stock::where('stock_id', $stockId)->first(); // Replace 'stock_id' with the actual column name if different

    if ($stock) {
        return response()->json(['description' => $stock->description]); // Assuming 'description' is the column name
    }

    return response()->json(['description' => null]); // If no stock found
}


}

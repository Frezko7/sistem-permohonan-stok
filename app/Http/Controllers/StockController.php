<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
{
    $query = Stock::query();

    // Check if there is a search query
    if ($request->has('search')) {
        $query->where('description', 'like', '%' . $request->search . '%')
              ->orWhere('id', 'like', '%' . $request->search . '%');
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

    return redirect()->route('stocks.index')->with('success', 'Stock added successfully!');
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
    // Validate input data
    $request->validate([
        'description' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1', // Ensure the quantity is at least 1
    ]);

    // Find the stock by ID
    $stock = Stock::findOrFail($id);

    // Update the stock with validated data
    $stock->description = $request->input('description');
    $stock->quantity = $request->input('quantity');

    // Save the changes to the stock
    $stock->save();

    // Redirect with success message
    return redirect()->route('stocks.index')->with('success', 'Stock updated successfully.');
}

    // Delete stock
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('stocks.index')->with('success', 'Stock deleted successfully.');
    }

    public function searchStocks(Request $request)
    {
        $search = $request->input('search');
        $stocks = Stock::where('id', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->take(5) // Limit results for performance
            ->get();

        return response()->json($stocks);
    }
}

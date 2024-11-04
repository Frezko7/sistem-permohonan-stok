<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::all();
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        return view('stocks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        Stock::create([
            'description' => $request->description,
            'quantity' => $request->quantity,
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
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            // Other validation rules...
        ]);

        $stock = Stock::findOrFail($id);
        $stock->name = $request->input('name');
        $stock->quantity = $request->input('quantity');
        // Update other fields...

        $stock->save();

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

<?php

namespace App\Http\Controllers;

use App\Models\Stock;

class CatalogController extends Controller
{
    public function index()
    {
        // Fetch all stock items
        $stocks = Stock::all(); 

        return view('catalog.index', compact('stocks'));
    }

    public function show($stock_id)
   {
    $stock = Stock::findOrFail($stock_id);

    return view('catalog.show', compact('stock'));
   }

}

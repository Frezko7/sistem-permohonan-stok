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

    public function show($id)
   {
    $stock = Stock::findOrFail($id);

    return view('catalog.show', compact('stock'));
   }

}

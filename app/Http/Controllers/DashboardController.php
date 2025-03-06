<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Stock;
use App\Models\StockRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function showDashboard()
    {
        $userId = auth()->id(); // Get the logged-in user's ID

        // Fetch stock requests that are either 'pending' or 'approved' for the logged-in user
        $requests = StockRequest::with('stock')
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'approved','rejected'])
            ->get();

        // Count total stock in the database
        $totalStock = Stock::count();

        // Pass the requests, total stock, and additional data to the view
        return view('dashboard', [
            'requests' => $requests,
            'userCount' => User::count(), // Example additional data
            'totalRequests' => StockRequest::count(), // Total stock requests
            'totalStock' => $totalStock, // Total stock count
        ]);
    }
}
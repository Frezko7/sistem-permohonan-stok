<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            ->whereIn('status', ['pending', 'approved'])
            ->get();

        // Pass the requests and additional data to the view
        return view('dashboard', [
            'requests' => $requests,
            'userCount' => User::count(), // Example additional data
        ]);
    }
}


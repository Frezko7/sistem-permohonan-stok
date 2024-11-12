<?php

namespace App\Http\Controllers;

use App\Models\User; // Import the User model
use Illuminate\Http\Request;
use App\Models\StockRequest;

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
    $approvedRequests = StockRequest::with('stock')
        ->where('user_id', $userId)
        ->where('status', 'approved')
        ->get();

    // Pass the variable to the view
    return view('dashboard', [
        'approvedRequests' => $approvedRequests,
        'userCount' => User::count(), // Example additional data
    ]);
}

}

<?php

namespace App\Http\Controllers;

use App\Models\User; // Import the User model
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the count of registered users
        $userCount = User::count(); 

        // Pass the user count to the view
        return view('dashboard', compact('userCount'));
    }
}

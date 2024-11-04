<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::middleware('usertype:admin')->group(function () {
        Route::resource('stocks', StockController::class)->except(['show']);

        // Route for viewing all stock requests
        Route::get('/stock-requests', [StockRequestController::class, 'index'])->name('stock_requests.index');

        // Show the approval form (GET request)
        Route::get('/stock_requests/{stockRequest}/approve', [StockRequestController::class, 'showApprovalForm'])->name('stock_requests.showApprovalForm');

        // Process the approval (POST request)
        Route::post('/stock_requests/{stockRequest}/approve', [StockRequestController::class, 'approve'])->name('stock_requests.approve');

        // Reject stock request
        Route::get('/stock_requests/{stockRequest}/reject', [StockRequestController::class, 'reject'])->name('stock_requests.reject');
    });

    // Applicant routes
    Route::middleware('usertype:applicant')->group(function () {
        Route::resource('stock_requests', StockRequestController::class)->only(['create', 'store',]); // Applicants can create and view requests
        // In web.php (routes file)
        Route::get('/stocks/search', [StockController::class, 'searchStocks'])->name('stocks.search');
    });
});


// Include the authentication routes
require __DIR__ . '/auth.php';

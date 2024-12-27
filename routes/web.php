<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');



// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');

    Route::get('/stock/{id}', [CatalogController::class, 'show'])->name('stock.show');

    // Search for stocks
    Route::get('/catalog/search', [StockController::class, 'search'])->name('catalog.search');

    Route::get('/stocks/search', [StockController::class, 'search'])->name('stocks.search');

    Route::get('/stock-suggestions', [StockController::class, 'getSuggestions'])->name('stock.suggestions');

    // Route for previewing the report before generating
    Route::get('/stock-requests/report/{groupId}/view', [StockRequestController::class, 'viewReport'])->name('stock_requests.view');


    // Admin routes
    Route::middleware('usertype:admin')->group(function () {
        Route::resource('stocks', StockController::class)->except(['show']);

        // Route for viewing all stock requests
        Route::get('/stock-requests', [StockRequestController::class, 'index'])->name('stock_requests.index');
        

        // Show the approval form (GET request)
        Route::get('/stock_requests/{stockRequest}/approve', [StockRequestController::class, 'showApprovalForm'])->name('stock_requests.showApprovalForm');

        // Process the approval (POST request)
        Route::post('/stock_requests/{stockRequest}/approve', [StockRequestController::class, 'approve'])->name('stock_requests.approve');

        Route::post('/stock_requests/approve_all', [StockRequestController::class, 'approveAll'])->name('stock_requests.approve_all');

        // Reject stock request
        Route::get('/stock_requests/{stockRequest}/reject', [StockRequestController::class, 'reject'])->name('stock_requests.reject');

        // Generate report
        Route::get('/stock-requests/report/{groupId}', [StockRequestController::class, 'generateReport'])->name('stock_requests.report');
        
        
    });

    // Applicant routes
    Route::middleware('usertype:applicant')->group(function () {
        Route::resource('stock_requests', StockRequestController::class)->only(['create', 'store']); // Applicants can create and view requests

        Route::get('/stock-requests/receive/{groupId}', [StockRequestController::class, 'showReceivedQuantityForm'])->name('stock_requests.receive');
        Route::put('/stock-requests/update-received-quantities/{groupId}', [StockRequestController::class, 'updateReceivedQuantities'])->name('stock_requests.update_received_quantities');        
    });
    

});

// Include the authentication routes
require __DIR__ . '/auth.php';

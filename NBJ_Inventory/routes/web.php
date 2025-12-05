<?php

use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Http\Controllers\AuthenticationController as Authentication;
use App\Http\Controllers\PageController;
use App\Http\Controllers\KitchenController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/* |--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Root URL: Redirects immediately to the login page
Route::get('/', function() {
    return redirect()->route('login');
})->name('index');


/* --- AUTHORIZATION PAGES (Public) --- */

Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/login-password', [Authentication::class, 'login'])->name('login.submit');


/* --- MAIN SYSTEM PAGES (Protected) --- */
Route::middleware(['auth'])->group(function () {

    // --- FIX IS HERE: Point to the Controller, not a function() ---
    // The Controller calculates the totals, the stock alerts, and handles search.
    Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');

    // History / Audit Log Page
    Route::get('/history', function() {
        // Get all transactions, newest first
        $logs = \App\Models\Transaction::orderBy('created_at', 'desc')->get();
        return view('history', ['logs' => $logs]);
    })->name('history');

    // Show the "Add Item" form
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

    // Handle the form submission (Save the item)
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // Quick Stock Update Route
    Route::patch('/products/{id}/stock', [ProductController::class, 'adjustStock'])->name('products.adjustStock');

    // Show the "Edit Item" form
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');

    // Printable Report Route
    Route::get('/report', [ProductController::class, 'printReport'])->name('products.report');
    
    Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
    
    Route::post('/kitchen/update/{id}', [KitchenController::class, 'updateStatus'])->name('kitchen.update');

    // Handle the update (Save changes)
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

    // Delete a product
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Logout Route
    Route::post('/logout', function() {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');

});
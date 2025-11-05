<?php

use App\Http\Controllers\AuthenticationController as Authentication;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CashierPageController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function(){ 
    return redirect()->route('login');
})->name('index');

/* AUTHORIZATION PAGES */
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/login-password', [Authentication::class, 'login'])->name('login.submit');
Route::post('/logout', [Authentication::class, 'logout'])->name('logout');
/********************************************************************************************************/

/* HOME REDIRECTORY */
Route::get('/home', [PageController::class, 'home'])->name('home');
/********************************************************************************************************/

/* CUSTOMER PAGES */
Route::get('/cashier/dashboard', [CashierPageController::class, 'dashboard'])->name('cashier.dashboard');
Route::get('/cashier/orders', [CashierPageController::class, 'orders'])->name('cashier.orders');
Route::get('/cashier/help', [CashierPageController::class, 'help'])->name('cashier.help');
/********************************************************************************************************/
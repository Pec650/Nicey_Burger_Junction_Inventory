<?php

use App\Http\Controllers\AuthenticationController as Authentication;
use App\Http\Controllers\PageController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function(){ function() {
    return redirect()->route('login');
};})->name('index');

/* AUTHORIZATION PAGES */
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/login-password', [Authentication::class, 'login'])->name('login.submit');
/********************************************************************************************************/
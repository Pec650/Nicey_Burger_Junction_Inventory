<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CashierPageController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check()) {
            return abort(404);
        }

        return view('home.cashier.dashboard')
             ->with('nav_title', "Dashboard");
    }

    public function orders()
    {
        if (!Auth::check()) {
            return abort(404);
        }

        return view('home.cashier.orders')
             ->with('nav_title', "Orders");
    }

    public function help()
    {
        if (!Auth::check()) {
            return abort(404);
        }

        return view('home.cashier.help')
             ->with('nav_title', "Help");
    }
}

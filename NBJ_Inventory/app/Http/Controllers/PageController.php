<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function login()
    {
        return view('auth.login')->with('email', session('email') ? session('email') : null);
    }
}

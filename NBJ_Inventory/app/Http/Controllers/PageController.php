<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PageController extends Controller
{
    public function login()
    {
        return view('auth.login')->with('email', session('email') ? session('email') : null);
    }

    public function home()
    {
        if (!Auth::check()) {
            return abort(404);
        }

        $user_type = strtolower(User::where('id', Auth::id())->first()['user_type']);
        switch ($user_type) {
            case 'cashier':
                return redirect()->route("cashier.dashboard");
            case 'manager':
                return abort(404);
            case 'admin':
                return abort(404);
        }

        return abort(404);
    }
}

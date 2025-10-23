<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $user = User::where('email', $request['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email address not found.']);
        }

        if (!$request->has('password')) {
            session()->flash('email', $user['email']);
            return redirect()->route('login');
        }

        if ($request->input('password') == "") {
            return back()->with('email', $user['email'])
                         ->withErrors(['password' => 'The password field is required.']);
        }

        if (Hash::check($request['password'], $user['password'])) {
            Auth::login($user);
            return abort(404);
        }

        session()->flash('email', $user['email']);
        return back()->with('email', $user['email'])
                     ->withErrors(['password' => 'Incorrect Password']);
    }
}

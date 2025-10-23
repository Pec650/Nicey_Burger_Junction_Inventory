@extends('layouts.auth_layout')
@section('title', 'Authorization')
@section('styles')
    @vite('resources/css/auth/login.css')
@endsection
@section('content')
<div class="main-container">
    <div class="login-container">
        <h1>WELCOME</h1>
        <form action="{{ route('login.submit') }}" method="POST">
            @csrf
            @if ($email)
                <p>Email: <u>{{ $email }}</u></p>
                <input type="hidden" name="email" value="{{ $email }}">
                <label for="password">Password:</label><br>
                <div class="password-container">
                    <input type="password" name="password" id="password-input">
                    <div class="eye-container">
                        <div class="show-pass" id="show-password"><div class="hide-pass" id="hide-password"></div></div>
                    </div>
                </div><br>
            @else
                <label for="email">Email:</label><br>
                <input type="text" name="email"><br>
            @endif
            @if ($errors->any())
                <p id="error">{{ $errors->first() }}</p>
            @endif
            @if ($email)
                <div class="submission-container with-email">
                    <input type="submit" value="Login">
                    <a>Forgot Password?</a>
                </div>
            @else
                <div class="submission-container">
                    <input type="submit" value="Continue">
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
@section('script')
    @vite(['resources/js/auth/login.js'])
@endsection
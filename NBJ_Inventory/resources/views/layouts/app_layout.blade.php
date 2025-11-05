<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BurgerJunction')</title>
    @vite(['resources/css/app.css', 'resources/css/home.css', 'resources/js/app.js'])
    @yield('styles')
</head>
<body>
    @include('reusable.navbar')
    <main>
        @include('reusable.sidebar')
        <div id="main-content">
            @yield('content')
        </div>
    </main>
    @yield('script')
</body>
</html>
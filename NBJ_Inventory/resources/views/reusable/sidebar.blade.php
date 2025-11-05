@vite(['resources/css/reusable/sidebar.css'])
<div id="sidebar">
    <div>
        <button id="dashboard" 
            @if ($nav_title and strtolower($nav_title) == "dashboard") class="selected" @endif
            onclick="window.location.href='{{ route('cashier.dashboard') }}'">
            <img src="{{ asset('images/Icons/dashboardIcon.png') }}">Dashboard
        </button>
        <button id="orders" 
            @if ($nav_title and strtolower($nav_title) == "orders") class="selected" @endif
            onclick="window.location.href='{{ route('cashier.orders') }}'">
            <img src="{{ asset('images/Icons/ordersIcon.png') }}">Orders
        </button>
        <button id="help"
            @if ($nav_title and strtolower($nav_title) == "help") class="selected" @endif
            onclick="window.location.href='{{ route('cashier.help') }}'">
            <img src="{{ asset('images/Icons/helpIcon.png') }}">Help
        </button>
    </div>
</div>
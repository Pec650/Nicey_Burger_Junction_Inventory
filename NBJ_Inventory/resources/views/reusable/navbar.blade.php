@vite(['resources/css/reusable/navtab.css', 'resources/js/reusable/navtab.js'])
<nav id="navbar">
    <img src="{{ asset('images/Icons/LogoIcon.png') }}" id="logo">
    @if ($nav_title)
        <h3 id="page-title">{{ $nav_title }}</h3>
    @endif
    <div id="profile-container">
        <img id="profile-button" src="{{ asset('images/Icons/TemporaryImage.png') }}">
    </div>
</nav>
<div id="profile-drop-down">
    <center><img id="profile-picture"  src="{{ asset('images/Icons/TemporaryImage.png') }}"></center>
    <center><h4>Cashier123111111111114</h4></center>
    <center><button>Profile</button></center>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <center><button>Log Out</button></center>
    </form>
</div>
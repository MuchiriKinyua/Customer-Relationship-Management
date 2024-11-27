<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CustomerCRM</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Styles -->
</head>
<body class="antialiased">
    
<div class="image-container">
    <img src="{{ asset('images/crm-strategy.webp') }}" alt="Welcome to CustomerCRM">
</div>

    <div class="login">
        @if (Route::has('login'))
            <div class="register">
                @auth
                    <a href="{{ url('/home') }}" class="home-link">Home</a>
                @else
                    <div class="links">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="register-link ">Register</a>
                        @endif
                        <a href="{{ route('login') }}" class="login-link">Log In</a>
                    </div>
                @endauth
            </div>
        @endif
    </div>
    <div class="quote"><p>“Customer service is not a transaction; its about building relationships.” ~ Muchiri.</p></div>
    
</body>
</html>

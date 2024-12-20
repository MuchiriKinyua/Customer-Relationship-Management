<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CustomerCRM</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            margin: 0;
            font-family: 'figtree', sans-serif;
            background: linear-gradient(to right, #ff758c, #7a81ff);
            color: white;
            overflow-x: hidden;
        }

        .header {
            text-align: center;
            padding: 50px 20px;
        }

        .header h1 {
            font-size: 3rem;
            font-weight: bold;
            margin: 0;
            animation: slideIn 2s ease;
        }

        .header p {
            font-size: 1.5rem;
            margin-top: 10px;
            animation: fadeIn 3s ease;
        }

        .icons-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin: 40px auto;
        }

        .icon {
            width: 150px;
            height: 150px;
            background: white;
            color: #7a81ff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }

        .icon:hover {
            transform: scale(1.2);
            background: #ff758c;
            color: white;
        }

        .login {
            text-align: center;
            margin-top: 30px;
        }

        .login a {
            text-decoration: none;
            background: white;
            color: #7a81ff;
            padding: 15px 30px;
            border-radius: 25px;
            margin: 10px;
            font-weight: bold;
            transition: background 0.3s, color 0.3s;
        }

        .login a:hover {
            background: #ff758c;
            color: white;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to CustomerCRM</h1>
        <p>Your all-in-one customer management solution</p>
    </div>

    <div class="icons-container">
    <div class="icon">
        📊
        <p>Analytics</p>
    </div>
    <div class="icon">
        🤝
        <p>Customer Support</p>
    </div>
    <div class="icon">
        ⭐
        <p>Feedback</p>
    </div>
    <div class="icon">
        💼
        <p>Business Tools</p>
    </div>
    <div class="icon">
        📞
        <p>Communication</p>
    </div>
</div>


    <div class="login">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/home') }}" class="home-link">Dashboard</a>
            @else
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="register-link">Register</a>
                @endif
                <a href="{{ route('login') }}" class="login-link">Log In</a>
            @endauth
        @endif
    </div>
</body>
</html>

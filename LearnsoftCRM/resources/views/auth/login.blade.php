<x-laravel-ui-adminlte::adminlte-layout>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <body class="hold-transition login-page"
        style="background: linear-gradient(to right, rgba(122, 129, 255, 0.7), rgba(255, 117, 140, 0.7)), 
        url('{{ asset('storage/backgrounds/login-background.png') }}') no-repeat center center/cover; 
        color: white;">

        <div class="login-box">
            <div class="login-logo" style="animation: fadeIn 2s;">
            </div>

            <!-- Card -->
            <div class="card" style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); border-radius: 10px;">
                <div class="card-body login-card-body" style="background-color: #ffffff; border-radius: 10px;">
                    <p class="login-box-msg" style="font-size: 1.2rem; color: #555;">Sign in to start your session</p>

                    <!-- Login Form -->
                    <form method="post" action="{{ url('/login') }}">
                        @csrf

                        <!-- Email Input -->
                        <div class="input-group mb-3">
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                                class="form-control @error('email') is-invalid @enderror" style="border-radius: 25px;">
                            <div class="input-group-append">
                                <div class="input-group-text" style="background: #ff758c; color: white; border-radius: 50%;">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            @error('email')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="input-group mb-3">
                            <input type="password" name="password" placeholder="Password"
                                class="form-control @error('password') is-invalid @enderror" style="border-radius: 25px;">
                            <div class="input-group-append">
                                <div class="input-group-text" style="background: #7a81ff; color: white; border-radius: 50%;">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @error('password')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Remember Me + Sign In Button -->
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember">
                                    <label for="remember">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block"
                                    style="background: #7a81ff; border: none; border-radius: 25px;">Sign In</button>
                            </div>
                        </div>
                    </form>

                    <!-- Additional Links -->
                    <p class="mb-1">
                        <a href="{{ route('password.request') }}" style="color: #7a81ff;">I forgot my password</a>
                    </p>
                    <p class="mb-0">
                        <a href="{{ route('register') }}" class="text-center" style="color: #ff758c;">Register a new membership</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</x-laravel-ui-adminlte::adminlte-layout>

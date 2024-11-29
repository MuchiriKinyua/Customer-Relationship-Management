<x-laravel-ui-adminlte::adminlte-layout>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <body class="hold-transition register-page"
        style="background: linear-gradient(to right, rgba(122, 129, 255, 0.7), rgba(255, 117, 140, 0.7)), 
        url('{{ asset('images/background.png') }}') no-repeat center center fixed; background-size: cover; color: white;">

        <div class="register-box" style="background: rgba(255, 255, 255, 0.85); border-radius: 15px; box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.3); padding: 20px;">
            <div class="register-logo" style="animation: fadeIn 2s;">
                <h1 style="font-weight: bold; font-size: 2.5rem; color: #7a81ff;">CustomerCRM</h1>
            </div>

            <!-- Registration Card -->
            <div class="card" style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); border-radius: 10px;">
                <div class="card-body register-card-body" style="background-color: #ffffff; border-radius: 10px;">
                    <p class="login-box-msg" style="font-size: 1.2rem; color: #555;">Register a new membership</p>

                    <!-- Registration Form -->
                    <form method="post" action="{{ route('register') }}">
                        @csrf

                        <!-- Name Field -->
                        <div class="input-group mb-3">
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="Full name" style="border-radius: 25px;">
                            <div class="input-group-append">
                                <div class="input-group-text" style="background: #7a81ff; color: white; border-radius: 50%;">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="input-group mb-3">
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="Email" style="border-radius: 25px;">
                            <div class="input-group-append">
                                <div class="input-group-text" style="background: #ff758c; color: white; border-radius: 50%;">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="input-group mb-3">
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Password" style="border-radius: 25px;">
                            <div class="input-group-append">
                                <div class="input-group-text" style="background: #7a81ff; color: white; border-radius: 50%;">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="input-group mb-3">
                            <input type="password" name="password_confirmation"
                                class="form-control" placeholder="Retype password" style="border-radius: 25px;">
                            <div class="input-group-append">
                                <div class="input-group-text" style="background: #ff758c; color: white; border-radius: 50%;">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <!-- reCAPTCHA -->
                        <div>
                            {!! htmlFormSnippet() !!}
                            @if($errors->has('g-recaptcha-response'))
                                <small class="text-danger">{{ $errors->first('g-recaptcha-response') }}</small>
                            @endif
                        </div>

                        <!-- Terms Checkbox and Register Button -->
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                    <label for="agreeTerms">
                                        I agree to the <a href="#" style="color: #7a81ff;">terms</a>
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block"
                                    style="background: #7a81ff; border: none; border-radius: 25px;">Register</button>
                            </div>
                        </div>
                    </form>

                    <!-- Login Redirect -->
                    <p class="mb-0" style="text-align: center;">
                        <a href="{{ route('login') }}" class="text-center" style="color: #ff758c;">I already have a membership</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</x-laravel-ui-adminlte::adminlte-layout>

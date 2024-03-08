@extends('auth.layout')

@section('auth')
    <div class="login-page d-flex align-items-center bg-gray-100">
        <div class="container mb-3">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-body p-5">
                            <header class="text-center mb-5">
                                <h1 class="text-xxl text-gray-400 text-uppercase">BIMBA
                                    <strong class="text-primary">Rainbow Kids</strong>
                                </h1>
                            </header>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="row mb-3">
                                    <div class="form-group">
                                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong><small>{{ $message }}</small></strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="form-label">{{ __('Password') }}</label>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong><small>{{ $message }}</small></strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </form>
                            <br>
                            <a class="text-xs text-paleBlue" href="{{ route('password.request') }}">Forgot Password?
                            </a>
                            <br>
                            <span class="text-xs mb-0 text-gray-500">Do not have an account?
                            </span>
                            <a class="text-xs text-paleBlue ms-1" href="{{ route('register') }}"> Register</a>
                            <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center position-absolute bottom-0 start-0 w-100 z-index-20">
            <p class="text-gray-500">Design by <a class="external" href="#">Bimba Rainbow Kids</a>
                <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)                      -->
            </p>
        </div>
    </div>
@endsection

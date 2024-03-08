@extends('auth.layout')

@section('auth')
    <div class="login-page d-flex align-items-center bg-gray-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Register') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="row mb-3">
                                    <div class="form-group">
                                        <label for="name" class="form-label">{{ __('Fullname') }}</label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong><small>{{ $message }}</small></strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="form-label">{{ __('Email') }}</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email">

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

                                    <div class="form-group">
                                        <label for="password_confirmation"
                                            class="form-label">{{ __('Password Confirm') }}</label>
                                        <input id="password_confirmation" type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            name="password_confirmation">

                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong><small>{{ $message }}</small></strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">Register</button>
                            </form>

                            <br>
                            <span class="text-xs mb-0 text-gray-500">Do you have already account?
                            </span>
                            <a class="text-xs text-paleBlue ms-1" href="{{ route('login') }}"> Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

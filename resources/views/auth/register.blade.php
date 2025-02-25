@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-md-6">
        <link rel="stylesheet" href="style.css">
        <div class="card shadow-lg">
            <div class="mb-x" align="center">
                <p><h4>{{ __('Register') }}</h4></p>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name Field -->
                    <div class="mb-3 form-group">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">
                        @error('name')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="mb-3 form-group">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-3 form-group">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-3 form-group">
                        <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <!-- Register Button -->
                    <div align="center">
                        <button type="submit" >
                            {{ __('Register') }}
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="mt-3 text-center">
                        <p>Already have an account? <a href="{{ route('login') }}">{{ __('Login') }}</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

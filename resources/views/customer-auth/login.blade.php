@extends('layouts.app')

@section('title', 'Customer Login')

@section('content')

<div class="auth-page-wrapper">

    <div class="auth-container">
        <div class="auth-header">
            <h1>Customer Login</h1>
            <p>Enter your credentials to access your account</p>
        </div>

        <form class="auth-form" action="{{ route('customer.login.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-input" autocomplete="email">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-input" autocomplete="current-password">
            </div>

            <div class="form-group compact">
                <label for="remember" style="margin:0; cursor:pointer;">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
                </label>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" style="width:100%;">Login</button>
            </div>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="{{ route('customer.register') }}">Register</a>
        </div>
    </div>
</div>

@endsection
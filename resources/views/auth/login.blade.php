@extends('layouts.app')
@section('title', 'Login')
@section('content')

<div class="auth-container">
    <div class="auth-header">
        <h1>Pharmacy Management</h1>
        <p>Sign in to your account</p>
    </div>

    <form class="auth-form" action="{{ route('login.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-input" autocomplete="email">
            @error('email')
                <span style="color:#dc2626; font-size:0.85rem;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-input" autocomplete="current-password">
            @error('password')
                <span style="color:#dc2626; font-size:0.85rem;">{{ $message }}</span>
            @enderror
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
</div>

@endsection
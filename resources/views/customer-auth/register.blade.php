@extends('layouts.app')

@section('title', 'Customer Register')

@section('content')

<div class="auth-container">
    <div class="auth-header">
        <h1>Create Account</h1>
        <p>Register to track your purchase history</p>
    </div>

    <form class="auth-form" action="{{ route('customer.register.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <div class="form-group compact">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-input">
                @error('name')
                    <span style="color:#dc2626; font-size:0.85rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group compact">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-input">
                @error('phone')
                    <span style="color:#dc2626; font-size:0.85rem;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group compact">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-input">
            @error('email')
                <span style="color:#dc2626; font-size:0.85rem;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group compact">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-input">
            @error('password')
                <span style="color:#dc2626; font-size:0.85rem;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group compact">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input">
            @error('password_confirmation')
                <span style="color:#dc2626; font-size:0.85rem;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group compact">
            <label for="address">Address</label>
            <textarea name="address" id="address" class="form-input" rows="2">{{ old('address') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>

    <div class="auth-footer">
        Already have an account? <a href="{{ route('customer.login') }}">Login</a>
    </div>
</div>

@endsection
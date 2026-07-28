@extends('layouts.app')

@section('title', 'Customer Login')

@section('content')
<h2>Login</h2>

<form action="{{ route('customer.login.store') }}" method="POST">
    @csrf
        <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
        </div>
        <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        </div>
        <div>
        <label for="remember">Remember me</label>
        <input type="checkbox" name="remember" id="remember">
    </div>

    <button type="submit">Login</button>
</form>

@if(session('error'))
    <div>{{ session('error') }}</div>
@endif

<a href="{{ route('customer.register') }}">Don't have an account? Register</a>
@endsection
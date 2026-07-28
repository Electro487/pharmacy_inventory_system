@extends('layouts.app')

@section('title', 'Customer Register')

@section('content')
<h2>Register</h2>

<form action="{{ route('customer.register.store') }}" method="POST">
    @csrf
        <div>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
        </div>
        <div>
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" value="{{ old('phone') }}">
        </div>
        <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
        </div>
        <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        </div>
        <div>
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation">
        </div>
        <div>
        <label for="address">Address</label>
        <textarea name="address" id="address">{{ old('address') }}</textarea>
        </div>

    <button type="submit">Register</button>
</form>

<a href="{{ route('customer.login') }}">Already have an account? Login</a>
@endsection
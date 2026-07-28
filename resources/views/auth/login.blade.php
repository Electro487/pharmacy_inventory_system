@extends('layouts.app')
@section('title', 'Login')
@section('content')

<h2>Login</h2>

<form action="{{ route('login.store') }}" method="POST">
    @csrf

    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}">
    </div>
    
    <br>

    <div>
        <label>Password</label>
        <input type="password" name="password">
    </div>

    <br>

    <button type="submit">
        Login
    </button>

</form>

@endsection
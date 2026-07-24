@extends('layouts.app')

@section('title', 'Create Customer')

@section('content')
<h2>Create Customer</h2>

<form action="{{ route('customers.store') }}" method="POST">
    @csrf

    <div>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
        @error('name')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" value="{{ old('phone') }}">
        @error('phone')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
        @error('email')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="address">Address</label>
        <textarea name="address" id="address">{{ old('address') }}</textarea>
        @error('address')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="status">Status</label>
        <input type="checkbox" name="status" id="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
    </div>

    <button type="submit">Create</button>
</form>

<a href="{{ route('customers.index') }}">Back</a>
@endsection
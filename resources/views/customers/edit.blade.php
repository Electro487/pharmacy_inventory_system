@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<h2>Edit Customer</h2>

<form action="{{ route('customers.update', $customer->id) }}" method="POST">
    @csrf
    @method('PUT')
        <div>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}">
        </div>
        <div>
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" value="{{ old('phone', $customer->phone) }}">
        </div>
        <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}">
        </div>
        <div>
        <label for="address">Address</label>
        <textarea name="address" id="address">{{ old('address', $customer->address) }}</textarea>
        </div>
        <div>
        <label for="status">Status</label>
        <input type="checkbox" name="status" id="status" value="1" {{ old('status', $customer->status) ? 'checked' : '' }}>
    </div>

    <button type="submit">Update</button>
</form>

<a href="{{ route('customers.index') }}">Back</a>
@endsection
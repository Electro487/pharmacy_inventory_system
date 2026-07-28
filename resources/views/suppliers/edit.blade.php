@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<h2>Edit Supplier</h2>

<form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
    @csrf
    @method('PUT')
        <div>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $supplier->name) }}">
        </div>
        <div>
        <label for="company">Company</label>
        <input type="text" name="company" id="company" value="{{ old('company', $supplier->company) }}">
        </div>
        <div>
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" value="{{ old('phone', $supplier->phone) }}">
        </div>
        <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $supplier->email) }}">
        </div>
        <div>
        <label for="address">Address</label>
        <textarea name="address" id="address">{{ old('address', $supplier->address) }}</textarea>
        </div>
        <div>
        <label for="status">Status</label>
        <input type="checkbox" name="status" id="status" value="1" {{ old('status', $supplier->status) ? 'checked' : '' }}>
    </div>

    <button type="submit">Update</button>
</form>

<a href="{{ route('suppliers.index') }}">Back</a>
@endsection

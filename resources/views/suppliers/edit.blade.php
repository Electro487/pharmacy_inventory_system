@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<h2>Edit Supplier</h2>

<form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $supplier->name) }}">
        @error('name')
            <span style="color:#dc2626; font-size:0.85rem;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="company">Company</label>
        <input type="text" name="company" id="company" value="{{ old('company', $supplier->company) }}">
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" value="{{ old('phone', $supplier->phone) }}">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $supplier->email) }}">
    </div>

    <div class="form-group">
        <label for="address">Address</label>
        <textarea name="address" id="address">{{ old('address', $supplier->address) }}</textarea>
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <input type="checkbox" name="status" id="status" value="1" {{ old('status', $supplier->status) ? 'checked' : '' }}>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>

<a href="{{ route('suppliers.index') }}" class="btn btn-secondary btn-sm">Back</a>
@endsection
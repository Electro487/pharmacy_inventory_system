@extends('layouts.app')

@section('title', 'Create Supplier')

@section('content')
<h2>Create Supplier</h2>

<form action="{{ route('suppliers.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
        @error('name')
            <span style="color:#dc2626; font-size:0.85rem;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="company">Company</label>
        <input type="text" name="company" id="company" value="{{ old('company') }}">
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" value="{{ old('phone') }}">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
    </div>

    <div class="form-group">
        <label for="address">Address</label>
        <textarea name="address" id="address">{{ old('address') }}</textarea>
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <input type="checkbox" name="status" id="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
    </div>

    <button type="submit" class="btn btn-primary">Create</button>
</form>

<a href="{{ route('suppliers.index') }}" class="btn btn-secondary btn-sm">Back</a>
@endsection
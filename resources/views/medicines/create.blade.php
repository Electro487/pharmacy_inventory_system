@extends('layouts.app')

@section('title', 'Create Medicine')

@section('content')
<h2>Create Medicine</h2>

<form action="{{ route('medicines.store') }}" method="POST">
    @csrf

    <div>
        <label>Category</label>
        <select name="category_id">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Unit</label>
        <select name="unit_id">
            <option value="">Select Unit</option>
            @foreach($units as $unit)
                <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                    {{ $unit->name }}
                </option>
            @endforeach
        </select>
        @error('unit_id')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}">
        @error('name')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Generic Name</label>
        <input type="text" name="generic_name" value="{{ old('generic_name') }}">
        @error('generic_name')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Brand</label>
        <input type="text" name="brand" value="{{ old('brand') }}">
        @error('brand')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Selling Price</label>
        <input type="number" step="0.01" name="selling_price" value="{{ old('selling_price') }}">
        @error('selling_price')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Stock</label>
        <input type="number" name="stock" value="{{ old('stock', 0) }}">
        @error('stock')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Reorder Level</label>
        <input type="number" name="reorder_level" value="{{ old('reorder_level', 10) }}">
        @error('reorder_level')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Description</label>
        <textarea name="description">{{ old('description') }}</textarea>
        @error('description')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Status</label>
        <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
    </div>

    <button type="submit">Create</button>
</form>

<a href="{{ route('medicines.index') }}">Back</a>
@endsection

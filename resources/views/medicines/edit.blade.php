@extends('layouts.app')

@section('title', 'Edit Medicine')

@section('content')
<h2>Edit Medicine</h2>

<form action="{{ route('medicines.update', $medicine->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $medicine->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="unit_id">Unit</label>
        <select name="unit_id" id="unit_id">
            <option value="">Select Unit</option>
            @foreach($units as $unit)
                <option value="{{ $unit->id }}" {{ old('unit_id', $medicine->unit_id) == $unit->id ? 'selected' : '' }}>
                    {{ $unit->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $medicine->name) }}">
    </div>

    <div class="form-group">
        <label for="generic_name">Generic Name</label>
        <input type="text" name="generic_name" id="generic_name" value="{{ old('generic_name', $medicine->generic_name) }}">
    </div>

    <div class="form-group">
        <label for="brand">Brand</label>
        <input type="text" name="brand" id="brand" value="{{ old('brand', $medicine->brand) }}">
    </div>

    <div class="form-group">
        <label for="reorder_level">Reorder Level</label>
        <input type="number" name="reorder_level" id="reorder_level" value="{{ old('reorder_level', $medicine->reorder_level) }}" min="0">
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description">{{ old('description', $medicine->description) }}</textarea>
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <input type="checkbox" name="status" id="status" value="1" {{ old('status', $medicine->status) ? 'checked' : '' }}>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>

<a href="{{ route('medicines.index') }}" class="btn btn-secondary btn-sm">Back</a>
@endsection
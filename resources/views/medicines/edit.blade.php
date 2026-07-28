@extends('layouts.app')

@section('title', 'Edit Medicine')

@section('content')
<h2>Edit Medicine</h2>

<form action="{{ route('medicines.update', $medicine->id) }}" method="POST">
    @csrf
    @method('PUT')
        <div>
        <label>Category</label>
        <select name="category_id">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $medicine->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        </div>
        <div>
        <label>Unit</label>
        <select name="unit_id">
            <option value="">Select Unit</option>
            @foreach($units as $unit)
                <option value="{{ $unit->id }}" {{ old('unit_id', $medicine->unit_id) == $unit->id ? 'selected' : '' }}>
                    {{ $unit->name }}
                </option>
            @endforeach
        </select>
        </div>
        <div>
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name', $medicine->name) }}">
        </div>
        <div>
        <label>Generic Name</label>
        <input type="text" name="generic_name" value="{{ old('generic_name', $medicine->generic_name) }}">
        </div>
        <div>
        <label>Brand</label>
        <input type="text" name="brand" value="{{ old('brand', $medicine->brand) }}">
        </div>
        <div>
        <label>Reorder Level</label>
        <input type="number" name="reorder_level" value="{{ old('reorder_level', $medicine->reorder_level) }}">
        </div>
        <div>
        <label>Description</label>
        <textarea name="description">{{ old('description', $medicine->description) }}</textarea>
        </div>
        <div>
        <label>Status</label>
        <input type="checkbox" name="status" value="1" {{ old('status', $medicine->status) ? 'checked' : '' }}>
    </div>

    <button type="submit">Update</button>
</form>

<a href="{{ route('medicines.index') }}">Back</a>
@endsection

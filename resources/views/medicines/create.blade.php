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
        </div>
        <div>
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}">
        </div>
        <div>
        <label>Generic Name</label>
        <input type="text" name="generic_name" value="{{ old('generic_name') }}">
        </div>
        <div>
        <label>Brand</label>
        <input type="text" name="brand" value="{{ old('brand') }}">
        </div>
        <div>
        <label>Reorder Level</label>
        <input type="number" name="reorder_level" value="{{ old('reorder_level', 10) }}">
        </div>
        <div>
        <label>Description</label>
        <textarea name="description">{{ old('description') }}</textarea>
        </div>
        <div>
        <label>Status</label>
        <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
    </div>

    <button type="submit">Create</button>
</form>

<a href="{{ route('medicines.index') }}">Back</a>
@endsection

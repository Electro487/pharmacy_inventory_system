@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<h2>Edit Category</h2>

<form action="{{ route('categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}">
        @error('name')
            <span style="color:#dc2626; font-size:0.85rem;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description">{{ old('description', $category->description) }}</textarea>
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <input type="checkbox" name="status" id="status" value="1" {{ old('status', $category->status) ? 'checked' : '' }}>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>

<a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">Back</a>
@endsection
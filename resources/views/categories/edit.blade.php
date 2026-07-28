@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
    <h1>Edit Category</h1>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
            <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}">
            </div>
            <div>
            <label for="description">Description</label>
            <textarea name="description" id="description">{{ old('description', $category->description) }}</textarea>
            </div>
            <div>
            <label for="status">Status</label>
            <input type="checkbox" name="status" id="status" value="1" {{ old('status', $category->status) ? 'checked' : '' }}>
            </div>

        <button type="submit">Update</button>
    </form>

    <a href="{{ route('categories.index') }}">Back</a>
@endsection

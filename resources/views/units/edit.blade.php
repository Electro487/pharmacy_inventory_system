@extends('layouts.app')

@section('title', 'Edit Unit')

@section('content')
<h2>Edit Unit</h2>

<form action="{{ route('units.update', $unit->id) }}" method="POST">
    @csrf
    @method('PUT')
        <div>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $unit->name) }}">
        </div>
        <div>
        <label for="description">Description</label>
        <textarea name="description" id="description">{{ old('description', $unit->description) }}</textarea>
        </div>
        <div>
        <label for="status">Status</label>
        <input type="checkbox" name="status" id="status" value="1" {{ old('status', $unit->status) ? 'checked' : '' }}>
        </div>

    <button type="submit">Update</button>
</form>

<a href="{{ route('units.index') }}">Back</a>
@endsection

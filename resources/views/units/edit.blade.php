@extends('layouts.app')

@section('title', 'Edit Unit')

@section('content')
<h2>Edit Unit</h2>

<form action="{{ route('units.update', $unit->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $unit->name) }}">
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description">{{ old('description', $unit->description) }}</textarea>
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <input type="checkbox" name="status" id="status" value="1" {{ old('status', $unit->status) ? 'checked' : '' }}>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>

<a href="{{ route('units.index') }}" class="btn btn-secondary btn-sm">Back</a>
@endsection
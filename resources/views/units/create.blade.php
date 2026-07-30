@extends('layouts.app')

@section('title', 'Create Unit')

@section('content')
<h2>Create Unit</h2>

<form action="{{ route('units.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
        @error('name')
            <span style="color:#dc2626; font-size:0.85rem;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description">{{ old('description') }}</textarea>
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <input type="checkbox" name="status" id="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
    </div>

    <button type="submit" class="btn btn-primary">Create</button>
</form>

<a href="{{ route('units.index') }}" class="btn btn-secondary btn-sm">Back</a>
@endsection
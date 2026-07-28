@extends('layouts.app')

@section('title', 'Create Unit')

@section('content')
<h2>Create Unit</h2>

<form action="{{ route('units.store') }}" method="POST">
    @csrf
        <div>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
        </div>
        <div>
        <label for="description">Description</label>
        <textarea name="description" id="description">{{ old('description') }}</textarea>
        </div>
        <div>
        <label for="status">Status</label>
        <input type="checkbox" name="status" id="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
        </div>

    <button type="submit">Create</button>
</form>

<a href="{{ route('units.index') }}">Back</a>
@endsection

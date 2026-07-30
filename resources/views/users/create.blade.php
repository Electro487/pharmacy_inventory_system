@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<h2>Create User</h2>

<form action="{{ route('users.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="role_id">Role</label>
        <select name="role_id" id="role_id">
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <input type="checkbox" name="status" id="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
    </div>

    <button type="submit" class="btn btn-primary">Create</button>
</form>

<a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Back</a>
@endsection
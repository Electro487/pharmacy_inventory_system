@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<h2>Edit User</h2>

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Role</label>
        <select name="role_id">
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}">
    </div>

    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}">
    </div>

    <div>
        <label>Password</label>
        <input type="password" name="password">
        <small>Leave blank to keep current password.</small>
    </div>

    <div>
        <label>Status</label>
        <input type="checkbox" name="status" value="1" {{ old('status', $user->status) ? 'checked' : '' }}>
    </div>

    <button>Update</button>
</form>
@endsection

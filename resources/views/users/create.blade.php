@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<h2>Create User</h2>

<form action="{{ route('users.store') }}" method="POST">
    @csrf
        <div>
        <label>Role</label>
        <select name="role_id">
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
        </div>
        <div>
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}">
        </div>
        <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}">
        </div>
        <div>
        <label>Password</label>
        <input type="password" name="password">
        </div>
        <div>
        <label>Status</label>
        <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
    </div>

    <button>Create</button>
</form>
@endsection

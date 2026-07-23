@extends('layouts.app')

@section('title', 'Units')

@section('content')
<h2>Units</h2>

<a href="{{ route('units.create') }}">Add Unit</a>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @forelse($units as $unit)
        <tr>
            <td>{{ $unit->id }}</td>
            <td>{{ $unit->name }}</td>
            <td>{{ $unit->description ?? 'N/A' }}</td>
            <td>{{ $unit->status ? 'Active' : 'Inactive' }}</td>
            <td>
                <a href="{{ route('units.edit', $unit->id) }}">Edit</a>
                <form action="{{ route('units.destroy', $unit->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this unit?')">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No units found.</td>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $units->links() }}
@endsection

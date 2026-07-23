@extends('layouts.app')

@section('title', 'Medicines')

@section('content')
<h2>Medicines</h2>

<a href="{{ route('medicines.create') }}">Add Medicine</a>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Unit</th>
            <th>Name</th>
            <th>Generic Name</th>
            <th>Brand</th>
            <th>Selling Price</th>
            <th>Stock</th>
            <th>Reorder Level</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @forelse($medicines as $medicine)
        <tr>
            <td>{{ $medicine->id }}</td>
            <td>{{ $medicine->category->name }}</td>
            <td>{{ $medicine->unit->name }}</td>
            <td>{{ $medicine->name }}</td>
            <td>{{ $medicine->generic_name ?? 'N/A' }}</td>
            <td>{{ $medicine->brand ?? 'N/A' }}</td>
            <td>{{ $medicine->selling_price }}</td>
            <td>{{ $medicine->stock }}</td>
            <td>{{ $medicine->reorder_level }}</td>
            <td>{{ $medicine->status ? 'Active' : 'Inactive' }}</td>
            <td>
                <a href="{{ route('medicines.edit', $medicine->id) }}">Edit</a>
                <form action="{{ route('medicines.destroy', $medicine->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="11">No medicines found.</td>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $medicines->links() }}
@endsection

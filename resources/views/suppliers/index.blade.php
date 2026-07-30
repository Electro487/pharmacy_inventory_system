@extends('layouts.app')

@section('title', 'Suppliers')

@section('content')
<h2>Suppliers</h2>

<a href="{{ route('suppliers.create') }}" class="btn btn-primary">Add Supplier</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Company</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @forelse($suppliers as $supplier)
        <tr>
            <td>{{ $supplier->id }}</td>
            <td>{{ $supplier->name }}</td>
            <td>{{ $supplier->company ?? 'N/A' }}</td>
            <td>{{ $supplier->phone ?? 'N/A' }}</td>
            <td>{{ $supplier->email ?? 'N/A' }}</td>
            <td>{{ $supplier->address ?? 'N/A' }}</td>
            <td>{{ $supplier->status ? 'Active' : 'Inactive' }}</td>
            <td>
                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this supplier?')">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8">No suppliers found.</td>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $suppliers->links() }}
@endsection
@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<h2>Customers</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @forelse($customers as $customer)
        <tr>
            <td>{{ $customer->id }}</td>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->phone ?? 'N/A' }}</td>
            <td>{{ $customer->email ?? 'N/A' }}</td>
            <td>{{ $customer->address ?? 'N/A' }}</td>
            <td>{{ $customer->status ? 'Active' : 'Inactive' }}</td>
            <td>
                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this customer?')">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7">No customers found.</td>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $customers->links() }}
@endsection
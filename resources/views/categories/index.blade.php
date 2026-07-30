@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<h2>Categories</h2>

<a href="{{ route('categories.create') }}" class="btn btn-primary">Add Category</a>

<table>
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
    @forelse ($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->description ?? 'N/A' }}</td>
            <td>{{ $category->status ? 'Active' : 'Inactive' }}</td>
            <td>
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No categories found.</td>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $categories->links() }}
@endsection
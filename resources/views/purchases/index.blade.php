@extends('layouts.app')

@section('title', 'Purchases')

@section('content')
<h2>Purchases</h2>

<a href="{{ route('purchases.create') }}" class="btn btn-primary">Create Purchase</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Supplier</th>
            <th>Invoice No</th>
            <th>Purchase Date</th>
            <th>Total</th>
            <th>Remarks</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @forelse($purchases as $purchase)
        <tr>
            <td>{{ $purchase->id }}</td>
            <td>{{ $purchase->supplier->name }}</td>
            <td>{{ $purchase->invoice_no ?? '-' }}</td>
            <td>{{ $purchase->purchase_date }}</td>
            <td>{{ number_format($purchase->total_amount, 2) }}</td>
            <td>{{ $purchase->remarks ?? '-' }}</td>
            <td>
                <a href="{{ route('purchases.show', $purchase) }}" class="btn btn-secondary btn-sm">View</a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7">No purchases found.</td>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $purchases->links() }}
@endsection
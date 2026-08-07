@extends('layouts.app')

@section('title', 'Sales')

@section('content')
<h2>Sales</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Invoice No</th>
            <th>Sale Date</th>
            <th>Total</th>
            <th>Payment Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($sales as $sale)
            <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $sale->customer->name }}</td>
                <td>{{ $sale->invoice_no }}</td>
                <td>{{ $sale->sale_date }}</td>
                <td>{{ number_format($sale->total_amount, 2) }}</td>
                <td>
                    <span class="status-badge status-{{ $sale->payment_status->value }}">
                        {{ ucfirst($sale->payment_status->value) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('sales.show', $sale) }}" class="btn btn-secondary btn-sm">View</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No sales found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $sales->links() }}

@endsection
@extends('layouts.app')

@section('title', 'Purchase Details')

@section('content')

<h2>Purchase Details</h2>

<table border="0" cellpadding="5">
    <tr>
        <td><strong>Supplier:</strong></td>
        <td>{{ $purchase->supplier->name }}</td>
    </tr>
    <tr>
        <td><strong>Invoice:</strong></td>
        <td>{{ $purchase->invoice_no ?? '-' }}</td>
    </tr>
    <tr>
        <td><strong>Date:</strong></td>
        <td>{{ $purchase->purchase_date }}</td>
    </tr>
    <tr>
        <td><strong>Remarks:</strong></td>
        <td>{{ $purchase->remarks ?? '-' }}</td>
    </tr>
</table>

<br>

<table border="1">
    <thead>
        <tr>
            <th>Medicine</th>
            <th>Quantity</th>
            <th>Purchase Price</th>
            <th>Selling Price</th>
            <th>Subtotal</th>
        </tr>
    </thead>

    <tbody>
        @forelse($purchase->items as $item)
            <tr>
                <td>{{ $item->medicine->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->purchase_price, 2) }}</td>
                <td>{{ number_format($item->selling_price, 2) }}</td>
                <td>{{ number_format($item->subtotal, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No items found.</td>
            </tr>
        @endforelse
    </tbody>

    <tfoot>
        <tr>
            <th colspan="4">Total</th>
            <th>{{ number_format($purchase->total_amount, 2) }}</th>
        </tr>
    </tfoot>
</table>

<br>

<a href="{{ route('purchases.index') }}">Back</a>

@endsection

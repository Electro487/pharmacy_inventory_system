@extends('layouts.app')

@section('title', 'Sale Details')

@section('content')
<h2>Sale Details</h2>

<table border="0" cellpadding="5">
    <tr>
        <td><strong>Customer:</strong></td>
        <td>{{ $sale->customer->name }}</td>
    </tr>
    <tr>
        <td><strong>Invoice:</strong></td>
        <td>{{ $sale->invoice_no }}</td>
    </tr>
    <tr>
        <td><strong>Date:</strong></td>
        <td>{{ $sale->sale_date }}</td>
    </tr>
    <tr>
        <td><strong>Payment Status:</strong></td>
        <td>{{ ucfirst($sale->payment_status) }}</td>
    </tr>
    <tr>
        <td><strong>Remarks:</strong></td>
        <td>{{ $sale->remarks ?? '-' }}</td>
    </tr>
</table>

<br>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Medicine</th>
            <th>Quantity</th>
            <th>Selling Price</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @forelse($sale->items as $item)
        <tr>
            <td>{{ $item->medicine->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->selling_price, 2) }}</td>
            <td>{{ number_format($item->subtotal, 2) }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4">No items found.</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total</th>
            <th>{{ number_format($sale->total_amount, 2) }}</th>
        </tr>
    </tfoot>
</table>

<br>

<a href="{{ route('sales.index') }}">Back</a>
@endsection
@extends('layouts.app')
@section('title', 'Order Details')
@section('content')

<div class="sale-invoice">
    <div class="invoice-header">
        <div class="invoice-title">
            <h1>Order Details</h1>
            <span class="invoice-number">
                {{ $sale->invoice_no }}
            </span>
        </div>
        <div class="invoice-meta">
            <div>
                <strong>Date:</strong>
                {{ $sale->sale_date }}
            </div>
            <div>
                <strong>Payment:</strong>
                <span class="status-badge status-paid">
                    {{ ucfirst($sale->payment_status) }}
                </span>
            </div>
            <div>
                <strong>Total:</strong>
                Rs. {{ number_format($sale->total_amount, 2) }}
            </div>
        </div>
    </div>

    <div class="invoice-table-container">
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Medicine</th>
                    <th class="text-center">
                        Quantity
                    </th>
                    <th class="text-right">
                        Price
                    </th>
                    <th class="text-right">
                        Subtotal
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach($sale->items as $index => $item)
            <tr>
                <td>
                    {{ $index + 1 }}
                </td>
                <td>
                    {{ $item->medicine->name }}
                </td>
                <td class="text-center">
                    {{ $item->quantity }}
                </td>
                <td class="text-right">
                    Rs.
                    {{ number_format($item->selling_price,2) }}
                </td>
                <td class="text-right">
                    Rs.
                    {{ number_format($item->subtotal,2) }}
                </td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr class="grand-total-row">
                    <th colspan="4">
                        Grand Total
                    </th>
                    <th class="text-right">
                        Rs. {{ number_format($sale->total_amount,2) }}
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="invoice-actions">
        <a href="{{ route('customer.orders.index') }}" class="btn btn-secondary">
            Back to Orders
        </a>
    </div>
</div>

@endsection
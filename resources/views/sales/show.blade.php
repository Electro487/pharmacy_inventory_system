@extends('layouts.app')

@section('title', 'Sale Details')

@section('content')
<div class="sale-invoice">
    <div class="invoice-header">
        <div class="invoice-title">
            <h1>Sale Invoice</h1>
            <span class="invoice-number">{{ $sale->invoice_no }}</span>
        </div>
        <div class="invoice-meta">
            <div><strong>Date:</strong> {{ $sale->sale_date }}</div>
            <div><strong>Cashier:</strong> {{ $sale->user->name ?? 'N/A' }}</div>
            <div><strong>Customer:</strong> {{ $sale->customer->name }}</div>
            <div><strong>Status:</strong> <span class="status-badge status-{{ $sale->payment_status }}">{{ ucfirst($sale->payment_status) }}</span></div>
            @if($sale->remarks)
            <div><strong>Remarks:</strong> {{ $sale->remarks }}</div>
            @endif
        </div>
    </div>

    <div class="invoice-table-container">
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Medicine</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sale->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->medicine->name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->selling_price, 2) }}</td>
                    <td class="text-right">{{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No items found.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="grand-total-row">
                    <th colspan="4">Grand Total</th>
                    <th class="text-right grand-total-amount">{{ number_format($sale->total_amount, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="invoice-actions">
        <button class="btn btn-primary" onclick="window.print()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 6px;">
                <path d="M6 9V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v7"/>
                <path d="M4 14v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-10"/>
                <rect x="6" y="14" width="12" height="8"/>
            </svg>
            Print Invoice
        </button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Back to Sales</a>
    </div>
</div>

@endsection
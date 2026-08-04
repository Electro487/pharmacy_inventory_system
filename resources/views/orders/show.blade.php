@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="order-invoice">
    <div class="invoice-header">
        <div class="invoice-title">
            <h1>Order Details</h1>
            <span class="invoice-number">{{ $order->order_no }}</span>
        </div>
        <div class="invoice-meta">
            <div><strong>Date:</strong> {{ $order->order_date }}</div>
            <div><strong>Customer:</strong> {{ $order->customer->name }}</div>
            <div><strong>Status:</strong> <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></div>
            @if($order->approved_by)
            <div><strong>Approved By:</strong> {{ $order->approver->name }}</div>
            <div><strong>Approved At:</strong> {{ $order->approved_at }}</div>
            @endif
            @if($order->remarks)
            <div><strong>Remarks:</strong> {{ $order->remarks }}</div>
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
                @forelse($order->items as $index => $item)
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
                    <th class="text-right grand-total-amount">{{ number_format($order->total_amount, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="invoice-actions">
        @if($order->status === 'pending')
            <form action="{{ route('orders.approve', $order) }}" method="POST" style="display:inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-primary" onclick="return confirm('Approve this order? Stock will be deducted and sale created.')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 6px;">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Approve
                </button>
            </form>
            <form action="{{ route('orders.reject', $order) }}" method="POST" style="display:inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Reject this order? This cannot be undone.')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 6px;">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    Reject
                </button>
            </form>
        @endif

        <button class="btn btn-primary" onclick="window.print()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 6px;">
                <path d="M6 9V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v7"/>
                <path d="M4 14v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-10"/>
                <rect x="6" y="14" width="12" height="8"/>
            </svg>
            Print Order
        </button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
    </div>
</div>

<style>
.order-invoice {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.invoice-header {
    border-bottom: 2px solid var(--aqua-dark);
    padding-bottom: 20px;
    margin-bottom: 24px;
}

.invoice-title {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 16px;
}

.invoice-title h1 {
    margin: 0;
    font-size: 1.8rem;
    color: var(--aqua-dark);
}

.invoice-number {
    background: var(--aqua-base);
    color: var(--aqua-dark);
    padding: 6px 16px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 1rem;
    font-family: 'Inter', sans-serif;
}

.invoice-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 12px;
    padding: 16px;
    background: var(--aqua-base);
    border-radius: 8px;
}

.invoice-meta div {
    display: flex;
    gap: 8px;
}

.invoice-meta strong {
    color: var(--aqua-dark);
    min-width: 100px;
}

.status-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending {
    background: #fef3c7;
    color: #92400e;
}

.status-approved {
    background: #dcfce7;
    color: #166534;
}

.status-rejected {
    background: #fee2e2;
    color: #991b1b;
}

.status-completed {
    background: #dbeafe;
    color: #1e40af;
}

.invoice-table-container {
    overflow-x: auto;
    margin-bottom: 24px;
}

.invoice-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.95rem;
}

.invoice-table th,
.invoice-table td {
    padding: 12px 16px;
    text-align: left;
    border-bottom: 1px solid var(--cream-border);
}

.invoice-table th {
    background: var(--aqua-base);
    color: var(--aqua-dark);
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.invoice-table .text-center {
    text-align: center;
}

.invoice-table .text-right {
    text-align: right;
}

.invoice-table tbody tr:hover {
    background: var(--aqua-base);
}

.invoice-table tfoot .grand-total-row {
    background: var(--aqua-dark);
    color: var(--cream-white);
}

.invoice-table tfoot .grand-total-amount {
    font-size: 1.2rem;
    font-weight: 700;
}

.invoice-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    padding-top: 16px;
    border-top: 1px solid var(--cream-border);
}

@media print {
    .invoice-actions,
    header,
    aside,
    .btn-link {
        display: none !important;
    }
    .main-content {
        padding: 0 !important;
    }
    .order-invoice {
        max-width: none;
        padding: 0;
    }
    .invoice-header {
        border-bottom: 2px solid #0F766E !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .invoice-number {
        background: #E7F3F1 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .invoice-meta {
        background: #E7F3F1 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .status-pending {
        background: #fef3c7 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .status-approved {
        background: #dcfce7 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .invoice-table th {
        background: #E7F3F1 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .invoice-table tfoot .grand-total-row {
        background: #0F766E !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}
</style>
@endsection
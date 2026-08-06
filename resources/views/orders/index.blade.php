@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<h2>Orders</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Order No</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Total</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->order_no }}</td>
            <td>{{ $order->customer->name }}</td>
            <td>{{ $order->order_date }}</td>
            <td>{{ number_format($order->total_amount, 2) }}</td>
            <td>
                <span class="status-badge status-{{ $order->status->value }}">
                    {{ ucfirst($order->status->value) }}
                </span>
            </td>
            <td>
                <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary btn-sm">View</a>
                @if($order->status === \App\Enums\OrderStatus::Pending)
                    <form action="{{ route('orders.approve', $order) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Approve this order?')">Approve</button>
                    </form>
                    <form action="{{ route('orders.reject', $order) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Reject this order?')">Reject</button>
                    </form>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">No orders found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $orders->links() }}
@endsection
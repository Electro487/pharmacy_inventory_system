@extends('layouts.app')
@section('title', 'Customer Dashboard')
@section('content')

<h2>Welcome, {{ $customer->name }}</h2>

<div class="dashboard-grid">
    <div class="dashboard-card">
        <h3>🛒 Browse Medicines</h3>
        <p>Shop for available medicines.</p>
        <a href="{{ route('customer.medicines') }}" class="btn btn-secondary btn-sm">Browse</a>
    </div>
    <div class="dashboard-card">
        <h3>🛍 My Cart</h3>
        <p>View and manage your cart.</p>
        <a href="{{ route('customer.cart') }}" class="btn btn-secondary btn-sm">View Cart</a>
    </div>
    <div class="dashboard-card">
        <h3>📦 My Orders</h3>
        <h2>{{ $dashboard['totalOrders'] }}</h2>
        <p>Total orders placed.</p>
        <a href="{{ route('customer.orders.index') }}" class="btn btn-secondary btn-sm">
            View Orders
        </a>
    </div>
    <div class="dashboard-card">
        <h3>💰 Total Spent</h3>
        <h2>Rs. {{ number_format($dashboard['totalSpent'], 2) }}</h2>
        <p>Total amount spent.</p>
    </div>
</div>
<hr>
<h3>Recent Orders</h3>
@if($dashboard['recentOrders']->isEmpty())
    <p>You haven't placed any orders yet.</p>
@else
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Date</th>
                <th>Total</th>
                <th>Payment Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
@foreach($dashboard['recentOrders'] as $order)
            <tr>
                <td>{{ $order->order_no }}</td>
                <td>{{ $order->order_date }}</td>
                <td>Rs. {{ number_format($order->total_amount, 2) }}</td>
                <td>
                    <span class="status-badge status-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-secondary btn-sm">
                        View
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@endif
@endsection
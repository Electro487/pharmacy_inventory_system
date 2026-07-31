@extends('layouts.app')
@section('title', 'My Orders')
@section('content')

<h2>My Orders</h2>

@if($orders->isEmpty())
    <p>You have not placed any orders yet.</p>
@else

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Invoice</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $index => $order)
            <tr>
                <td>{{ $orders->firstItem() + $index }}</td>
                <td>
                    {{ $order->invoice_no }}
                </td>
                <td>
                    {{ $order->sale_date }}
                </td>
                <td>
                    Rs. {{ number_format($order->total_amount, 2) }}
                </td>
                <td>
                    {{ ucfirst($order->payment_status) }}
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

{{ $orders->links() }}

@endif

@endsection
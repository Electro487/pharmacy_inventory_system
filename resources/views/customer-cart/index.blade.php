@extends('layouts.app')

@section('title', 'My Cart')

@section('content')
<h2>My Cart</h2>

@if($cart->items->isEmpty())
    <div class="alert alert-info">
        Your cart is empty.
        <a href="{{ route('customer.medicines') }}" class="btn btn-primary btn-sm" style="margin-left: 10px;">Browse Medicines</a>
    </div>
@else
    <form action="{{ route('customer.cart.clear') }}" method="POST" style="margin-bottom: 20px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Clear entire cart?')">Clear Cart</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Medicine</th>
                <th class="text-center">Quantity</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Subtotal</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart->items as $item)
            <tr>
                <td>
                    <strong>{{ $item->medicine->name }}</strong><br>
                    <small>{{ $item->medicine->generic_name }} - {{ $item->medicine->brand }}</small>
                </td>
                <td class="text-center">
                    <form action="{{ route('customer.cart.update', $item->id) }}" method="POST" style="display:inline-flex; gap: 5px; align-items: center;">
                        @csrf
                        @method('PATCH')
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->medicine->stock }}" class="form-input" style="width: 70px;">
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </form>
                </td>
                <td class="text-right">{{ number_format($item->medicine->selling_price, 2) }}</td>
                <td class="text-right">{{ number_format($item->subtotal, 2) }}</td>
                <td>
                    <form action="{{ route('customer.cart.remove', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Remove this item?')">Remove</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total</th>
                <th class="text-right">{{ number_format($cart->total, 2) }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
        <a href="{{ route('customer.medicines') }}" class="btn btn-secondary">Continue Shopping</a>
        <form action="{{ route('customer.cart.checkout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-primary" onclick="return confirm('Place this order?')">Proceed to Checkout</button>
        </form>
    </div>
@endif
@endsection
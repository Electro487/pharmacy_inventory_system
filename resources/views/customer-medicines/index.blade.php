@extends('layouts.app')

@section('title', 'Medicines')

@section('content')
<h2>Available Medicines</h2>

@if($medicines->isEmpty())
    <div class="alert alert-info">No medicines available.</div>
@else
    <div class="medicine-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
        @foreach($medicines as $medicine)
        <div class="medicine-card" style="border: 1px solid var(--cream-border); border-radius: 12px; padding: 20px; background: var(--cream-white); box-shadow: 0 2px 8px rgba(0,0,0,0.04); transition: box-shadow 0.2s, transform 0.2s;">
            <div class="medicine-name" style="font-weight: 600; color: var(--aqua-dark); margin-bottom: 8px; font-size: 1.1rem;">{{ $medicine->name }}</div>
            
            <div class="medicine-details" style="font-size: 0.85rem; color: #666; margin-bottom: 12px;">
                <div>{{ $medicine->generic_name }} - {{ $medicine->brand }}</div>
                <div>{{ $medicine->category->name }} / {{ $medicine->unit->name }}</div>
            </div>

            <div class="medicine-price" style="font-size: 1.2rem; font-weight: 700; color: var(--aqua-dark); margin-bottom: 12px;">
                ${{ number_format($medicine->selling_price, 2) }}
            </div>

            <div class="medicine-stock" style="font-size: 0.8rem; color: {{ $medicine->stock < 10 ? '#dc2626' : '#166534' }}; margin-bottom: 16px;">
                {{ $medicine->stock }} in stock
            </div>

            <form action="{{ route('customer.cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="medicine_id" value="{{ $medicine->id }}">
                <div style="display: flex; gap: 8px;">
                    <input type="number" name="quantity" value="1" class="form-input" style="width: 70px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Add to Cart</button>
                </div>
            </form>
            
            <div style="margin-top: 8px;">
                <a href="{{ route('customer.medicines.show', $medicine) }}" class="btn btn-secondary btn-sm" style="font-size: 0.8rem;">View Details</a>
            </div>
        </div>
        @endforeach
    </div>

    {{ $medicines->links() }}
@endif
@endsection
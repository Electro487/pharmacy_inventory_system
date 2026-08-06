@extends('layouts.app')

@section('title', $medicine->name)

@section('content')
<div class="medicine-detail" style="max-width: 800px; margin: 0 auto;">
    <div class="medicine-header" style="margin-bottom: 24px;">
        <h1 style="color: var(--aqua-dark); margin-bottom: 8px;">{{ $medicine->name }}</h1>
        <div style="color: #666; margin-bottom: 4px;">{{ $medicine->generic_name }} - {{ $medicine->brand }}</div>
        <div style="color: #666;">{{ $medicine->category->name }} / {{ $medicine->unit->name }}</div>
    </div>

    <div class="medicine-price" style="font-size: 2rem; font-weight: 700; color: var(--aqua-dark); margin-bottom: 24px;">
        ${{ number_format($medicine->selling_price, 2) }}
    </div>

    <div class="medicine-info" style="background: var(--aqua-base); border-radius: 8px; padding: 20px; margin-bottom: 24px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <div>
                <strong>Available Stock:</strong>
                <div style="color: {{ $medicine->available_stock < 10 ? '#dc2626' : '#166534' }}; font-weight: 600;">
                    {{ $medicine->available_stock }} {{ $medicine->unit->name }}(s)
                </div>
            </div>
            <div>
                <strong>Category:</strong>
                <div>{{ $medicine->category->name }}</div>
            </div>
            <div>
                <strong>Unit:</strong>
                <div>{{ $medicine->unit->name }}</div>
            </div>

        </div>
    </div>

    @if($medicine->description)
    <div class="medicine-description" style="margin-bottom: 24px;">
        <h3 style="color: var(--aqua-dark); margin-bottom: 12px;">Description</h3>
        <div style="line-height: 1.7; color: #444;">{{ $medicine->description }}</div>
    </div>
    @endif

    <form action="{{ route('customer.cart.add') }}" method="POST">
        @csrf
        <input type="hidden" name="medicine_id" value="{{ $medicine->id }}">

        <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="1" class="form-input" style="width: 100px;">
            </div>

            <button type="submit" class="btn btn-primary" style="padding: 12px 32px; font-size: 1.1rem; flex: 1; max-width: 300px;">
                Add to Cart - ${{ number_format($medicine->selling_price, 2) }}
            </button>
        </div>
    </form>

    <div style="margin-top: 24px;">
        <a href="{{ route('customer.medicines') }}" class="btn btn-secondary">← Back to Medicines</a>
    </div>
</div>
@endsection
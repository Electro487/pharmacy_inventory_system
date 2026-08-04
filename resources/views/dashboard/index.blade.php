@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<h2>Dashboard</h2>

<p>
    Welcome,
    <strong>{{ auth()->user()->name }}</strong>
</p>

<p>
    Role:
    <strong>{{ auth()->user()->role->name }}</strong>
</p>

<hr>

@if(auth()->user()->isAdmin())

<h2>Admin Dashboard</h2>

<div class="dashboard-grid">

    <div class="dashboard-card">
        <h3>💊 Medicines</h3>
        <h3>{{ $dashboard['totalMedicines'] }}</h3>
        <p>Manage medicines and stock.</p>

        <a href="{{ route('medicines.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>🏷 Categories</h3>
        <h3>{{ $dashboard['totalCategories'] }}</h3>
        <p>Manage medicine categories.</p>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>📏 Units</h3>
        <h3>{{ $dashboard['totalUnits'] }}</h3>
        <p>Manage medicine units.</p>

        <a href="{{ route('units.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>📦 Purchases</h3>
        <h3>{{ $dashboard['totalPurchases'] }}</h3>
        <p>Purchase medicines.</p>

        <a href="{{ route('purchases.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>📋 Orders</h3>
        <h3>{{ $dashboard['totalOrders'] }}</h3>
        <p>View and approve orders.</p>

        <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>💰 Sales</h3>
        <h3>{{ $dashboard['totalSales'] }}</h3>
        <p>Create and manage sales.</p>

        <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>👥 Customers</h3>
        <h3>{{ $dashboard['totalCustomers'] }}</h3>
        <p>Manage customers.</p>

        <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>🚚 Suppliers</h3>
        <h3>{{ $dashboard['totalSuppliers'] }}</h3>
        <p>Manage suppliers.</p>

        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>👤 Users</h3>
        <h3>{{ $dashboard['totalUsers'] }}</h3>
        <p>Manage system users.</p>

        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

</div>
<hr style="margin:40px 0;">

<h2>⚠ Low Stock Medicines</h2>
@if($dashboard['lowStockMedicines']->isEmpty())
    <h3>No medicines are currently below their reorder level.</h3>
@else
    <table>
        <thead>
            <tr>
                <th>Medicine</th>
                <th>Stock</th>
                <th>Reorder Level</th>
            </tr>
        </thead>
        <tbody>
        @foreach($dashboard['lowStockMedicines'] as $medicine)
            <tr>
                <td>{{ $medicine->name }}</td>
                <td>{{ $medicine->stock }}</td>
                <td>{{ $medicine->reorder_level }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

<h2 style="margin-top:40px;">Recent Sales</h2>

@if($dashboard['recentSales']->isEmpty())
    <h3>No sales have been recorded yet.</h3>
@else
<table>
    <thead>
        <tr>
            <th>Invoice</th>
            <th>Customer</th>
            <th>Cashier</th>
            <th>Total</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dashboard['recentSales'] as $sale)
            <tr>
                <td>{{ $sale->invoice_no }}</td>
                <td>
                    {{ $sale->customer->name}}
                </td>
                <td>
                    {{ $sale->user->name }}
                </td>
                <td>
                    Rs. {{ number_format($sale->total_amount, 2) }}
                </td>
                <td>
                    {{ $sale->sale_date }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top:15px;">
    <a href="{{ route('sales.index') }}" class="btn btn-secondary">
        View All Sales
    </a>
</div>

@endif

@endif

@if(auth()->user()->isPharmacist())

<h2>Pharmacist Dashboard</h2>

<div class="dashboard-grid">

    <div class="dashboard-card">
        <h3>💊 Medicines</h3>
        <h3>{{ $dashboard['totalMedicines'] }}</h3>
        <p>Manage medicines and stock.</p>

        <a href="{{ route('medicines.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>🏷 Categories</h3>
        <h3>{{ $dashboard['totalCategories'] }}</h3>
        <p>Manage medicine categories.</p>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>📏 Units</h3>
        <h3>{{ $dashboard['totalUnits'] }}</h3>
        <p>Manage medicine units.</p>

        <a href="{{ route('units.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>🚚 Suppliers</h3>
        <h3>{{ $dashboard['totalSuppliers'] }}</h3>
        <p>Manage suppliers.</p>

        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>👥 Customers</h3>
        <h3>{{ $dashboard['totalCustomers'] }}</h3>
        <p>Manage customers.</p>

        <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>📦 Purchases</h3>
        <h3>{{ $dashboard['totalPurchases'] }}</h3>
        <p>Purchase medicines.</p>

        <a href="{{ route('purchases.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>📋 Orders</h3>
        <h3>{{ $dashboard['totalOrders'] }}</h3>
        <p>View and approve orders.</p>

        <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>💰 Sales</h3>
        <h3>{{ $dashboard['totalSales'] }}</h3>
        <p>Create and manage sales.</p>

        <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    
</div>

<hr style="margin:40px 0;">

<h2>⚠ Low Stock Medicines</h2>
@if($dashboard['lowStockMedicines']->isEmpty())
    <h3>No medicines are currently below their reorder level.</h3>
@else
    <table>
        <thead>
            <tr>
                <th>Medicine</th>
                <th>Stock</th>
                <th>Reorder Level</th>
            </tr>
        </thead>
        <tbody>
        @foreach($dashboard['lowStockMedicines'] as $medicine)
            <tr>
                <td>{{ $medicine->name }}</td>
                <td>{{ $medicine->stock }}</td>
                <td>{{ $medicine->reorder_level }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif


<h2 style="margin-top:40px;">Recent Sales</h2>

@if($dashboard['recentSales']->isEmpty())
    <h3>No sales have been recorded yet.</h3>
@else
<table>
    <thead>
        <tr>
            <th>Invoice</th>
            <th>Customer</th>
            <th>Cashier</th>
            <th>Total</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dashboard['recentSales'] as $sale)
            <tr>
                <td>{{ $sale->invoice_no }}</td>
                <td>
                    {{ $sale->customer->name}}
                </td>
                <td>
                    {{ $sale->user->name }}
                </td>
                <td>
                    Rs. {{ number_format($sale->total_amount, 2) }}
                </td>
                <td>
                    {{ $sale->sale_date }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top:15px;">
    <a href="{{ route('sales.index') }}" class="btn btn-secondary">
        View All Sales
    </a>
</div>

@endif

@endif

@if(auth()->user()->isCashier())

<h2>Cashier Dashboard</h2>

<div class="dashboard-grid">
    <div class="dashboard-card">
        <h3>💰 Sales</h3>
        <h3>{{ $dashboard['totalSales'] }}</h3>
        <p>View past sales.</p>

        <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>👥 Customers</h3>
        <h3>{{ $dashboard['totalCustomers'] }}</h3>
        <p>Manage customers.</p>

        <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

</div>


<h2 style="margin-top:40px;">Recent Sales</h2>

@if($dashboard['recentSales']->isEmpty())
    <h3>No sales have been recorded yet.</h3>
@else
<table>
    <thead>
        <tr>
            <th>Invoice</th>
            <th>Customer</th>
            <th>Cashier</th>
            <th>Total</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dashboard['recentSales'] as $sale)
            <tr>
                <td>{{ $sale->invoice_no }}</td>
                <td>
                    {{ $sale->customer->name}}
                </td>
                <td>
                    {{ $sale->user->name }}
                </td>
                <td>
                    Rs. {{ number_format($sale->total_amount, 2) }}
                </td>
                <td>
                    {{ $sale->sale_date }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top:15px;">
    <a href="{{ route('sales.index') }}" class="btn btn-secondary">
        View All Sales
    </a>
</div>

@endif


@endif

@endsection
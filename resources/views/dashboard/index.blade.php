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
        <p>Manage medicines and stock.</p>

        <a href="{{ route('medicines.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>🏷 Categories</h3>
        <p>Manage medicine categories.</p>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>📦 Purchases</h3>
        <p>Purchase medicines.</p>

        <a href="{{ route('purchases.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>💰 Sales</h3>
        <p>Create and manage sales.</p>

        <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>👥 Customers</h3>
        <p>Manage customers.</p>

        <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>🚚 Suppliers</h3>
        <p>Manage suppliers.</p>

        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>👤 Users</h3>
        <p>Manage system users.</p>

        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

</div>

@endif

@if(auth()->user()->isPharmacist())

<h2>Pharmacist Dashboard</h2>

<div class="dashboard-grid">

    <div class="dashboard-card">
        <h3>💊 Medicines</h3>
        <p>Manage medicines and stock.</p>

        <a href="{{ route('medicines.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>🏷 Categories</h3>
        <p>Manage medicine categories.</p>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>🚚 Suppliers</h3>
        <p>Manage suppliers.</p>

        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>👥 Customers</h3>
        <p>Manage customers.</p>

        <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>📦 Purchases</h3>
        <p>Purchase medicines.</p>

        <a href="{{ route('purchases.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>💰 Sales</h3>
        <p>Create and manage sales.</p>

        <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

</div>

@endif

@if(auth()->user()->isCashier())

<h2>Cashier Dashboard</h2>

<div class="dashboard-grid">

    <div class="dashboard-card">
        <h3>💰 Create Sale</h3>
        <p>Process a new sale.</p>

        <a href="{{ route('sales.create') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>📜 Sales History</h3>
        <p>View past sales.</p>

        <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

    <div class="dashboard-card">
        <h3>👥 Customers</h3>
        <p>Manage customers.</p>

        <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">Open</a>
    </div>

</div>

@endif

@endsection
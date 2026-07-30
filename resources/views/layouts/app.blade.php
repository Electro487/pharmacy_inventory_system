<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>@yield('title', 'Pharmacy')</title>
</head>
<body>

@if(auth()->guard('web')->check())
    <header>
        <div class="header-left">
            <h1>Pharmacy Management System</h1>
        </div>
        <div class="header-right">
            <span>
                Welcome,
                <strong>{{ auth()->user()->name }}</strong>
                ({{ auth()->user()->role->name }})
            </span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-link">
                    Logout
                </button>
            </form>
        </div>
    </header>

    <div class="container">
        <aside>
            <h3>Menu</h3>
            <ul>
                @if(auth()->user()->isAdmin())
                    <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                    <li><a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">Users</a></li>
                    <li><a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">Categories</a></li>
                    <li><a href="{{ route('medicines.index') }}" class="{{ request()->routeIs('medicines.*') ? 'active' : '' }}">Medicines</a></li>
                    <li><a href="{{ route('suppliers.index') }}" class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">Suppliers</a></li>
                    <li><a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">Customers</a></li>
                    <li><a href="{{ route('purchases.index') }}" class="{{ request()->routeIs('purchases.*') ? 'active' : '' }}">Purchases</a></li>
                    <li><a href="{{ route('sales.index') }}" class="{{ request()->routeIs('sales.*') ? 'active' : '' }}">Sales</a></li>
                @endif

                @if(auth()->user()->isPharmacist())
                    <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                    <li><a href="{{ route('medicines.index') }}" class="{{ request()->routeIs('medicines.*') ? 'active' : '' }}">Medicines</a></li>
                    <li><a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">Categories</a></li>
                    <li><a href="{{ route('suppliers.index') }}" class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">Suppliers</a></li>
                    <li><a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">Customers</a></li>
                    <li><a href="{{ route('purchases.index') }}" class="{{ request()->routeIs('purchases.*') ? 'active' : '' }}">Purchases</a></li>
                    <li><a href="{{ route('sales.index') }}" class="{{ request()->routeIs('sales.*') ? 'active' : '' }}">Sales</a></li>
                @endif

                @if(auth()->user()->isCashier())
                    <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                    <li><a href="{{ route('sales.create') }}" class="{{ request()->routeIs('sales.create') ? 'active' : '' }}">Create Sale</a></li>
                    <li><a href="{{ route('sales.index') }}" class="{{ request()->routeIs('sales.index') ? 'active' : '' }}">Sales History</a></li>
                    <li><a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">Customers</a></li>
                @endif
            </ul>
        </aside>

        <main class="main-content">
@elseif(auth()->guard('customer')->check())
    <header>
        <div class="header-left">
            <h1>Pharmacy Management System</h1>
        </div>
        <div class="header-right">
            <span>
                Welcome,
                <strong>{{ auth()->guard('customer')->user()->name }}</strong>
            </span>
            <form action="{{ route('customer.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-link">
                    Logout
                </button>
            </form>
        </div>
    </header>

    <div class="container">
        <aside>
            <h3>Menu</h3>
            <ul>
                <li><a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">Dashboard</a></li>
            </ul>
        </aside>

        <main class="main-content">
@else
        <main class="main-content auth-page">
@endif
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin:0; padding-left:20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    @if(auth()->guard('web')->check() || auth()->guard('customer')->check())
    </div>
@endif

</body>
</html>
<?php

namespace App\Services;
use App\Models\User;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Medicine;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Order;

class DashboardService
{
    public function getDashboardData(User $user): array
    {
        $lowStockMedicines = Medicine::whereColumn('stock', '<=', 'reorder_level')->orderBy('stock')->limit(5)->get();
        if ($user->isCashier()) {
            $recentSales = Sale::where('user_id', $user->id)
                ->with(['customer', 'user'])
                ->latest()
                ->limit(5)
                ->get();
        } else {
            $recentSales = Sale::with(['customer', 'user'])
                ->latest()
                ->limit(5)
                ->get();
        }

        $totalSales = $user->isCashier()? Sale::where('user_id', $user->id)->count() : Sale::count();

        return [
            'totalUsers' => User::count(),
            'totalCategories' => Category::count(),
            'totalUnits' => Unit::count(),
            'totalMedicines' => Medicine::count(),
            'totalSuppliers' => Supplier::count(),
            'totalCustomers' => Customer::count(),
            'totalPurchases' => Purchase::count(),
            'totalOrders' => Order::count(),
            'totalSales' => $totalSales,
            'lowStockMedicines' => $lowStockMedicines,
            'recentSales' => $recentSales,
        ];
    }
}
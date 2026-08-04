<?php

namespace App\Services;

class CustomerDashboardService
{
    public function getDashboardData($customer): array
    {
        $orders = $customer->orders()->latest();

        return [
            'totalOrders' => $orders->count(),
            'totalSpent' => $customer->sales()->sum('total_amount'),
            'recentOrders' => $orders->take(5)->get(),
        ];
    }
}
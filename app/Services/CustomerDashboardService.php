<?php

namespace App\Services;

class CustomerDashboardService
{
    public function getDashboardData($customer): array
    {
        $sales = $customer->sales()->latest();

        return [
            'totalOrders' => $sales->count(),
            'totalSpent' => $sales->sum('total_amount'),
            'recentOrders' => $sales->take(5)->get(),
        ];
    }
}
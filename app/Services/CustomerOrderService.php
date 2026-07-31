<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Sale;

class CustomerOrderService
{
    public function getOrders(Customer $customer)
    {
        return $customer->sales()
            ->latest()
            ->paginate(10);
    }

    public function getOrder(Customer $customer, int $saleId): Sale
    {
        return $customer->sales()
            ->with(['items.medicine'])
            ->findOrFail($saleId);
    }
}
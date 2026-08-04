<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Order;

class CustomerOrderService
{
    public function getOrders(Customer $customer)
    {
        return $customer->orders()
            ->latest()
            ->paginate(10);
    }

    public function getOrder(Customer $customer, int $orderId): Order
    {
        return $customer->orders()
            ->with(['items.medicine'])
            ->findOrFail($orderId);
    }
}
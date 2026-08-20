<?php

namespace App\Helpers;

use App\Models\Order;

trait GeneratesOrderNumbers
{
    private function generateOrderNumber(): string
    {
        $lastOrder = Order::latest('id')->first();
// $id = $latestOrder->id;
        if (!$lastOrder) {
            return 'ORD-000001';
        }

        $number = (int) str_replace('ORD-', '', $lastOrder->order_no);
        $number++;

        return 'ORD-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}
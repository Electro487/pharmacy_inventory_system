<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\CustomerOrderService;

class CustomerOrderController extends Controller
{
    protected CustomerOrderService $customerOrderService;

    public function __construct(CustomerOrderService $customerOrderService)
    {
        $this->customerOrderService = $customerOrderService;
    }

    public function index()
    {
        $customer = auth('customer')->user();
        $orders = $this->customerOrderService->getOrders($customer);

        return view('customer-orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $customer = auth('customer')->user();
        $order = $this->customerOrderService->getOrder($customer, $order->id);

        return view('customer-orders.show', compact('order'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
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

    public function show(Sale $sale)
    {
        $customer = auth('customer')->user();
        $sale = $this->customerOrderService->getOrder($customer, $sale->id);

        return view('customer-orders.show', compact('sale'));
    }
}

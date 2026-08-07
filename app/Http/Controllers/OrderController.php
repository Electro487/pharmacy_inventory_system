<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->getAll();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order = $this->orderService->getById($order->id);

        return view('orders.show', compact('order'));
    }

    public function approve(Order $order)
    {
        try {
            $this->orderService->approve($order);
            return redirect()->route('orders.show', $order)->with('success', 'Order approved and sale created.');
        } catch (\Exception $e) {
            return redirect()->route('orders.show', $order)->with('error', $e->getMessage());
        }
    }

    public function reject(Order $order)
    {
        try {
            $this->orderService->reject($order);
            return redirect()->route('orders.show', $order)->with('success', 'Order rejected.');
        } catch (\Exception $e) {
            return redirect()->route('orders.show', $order)->with('error', $e->getMessage());
        }
    }

    public function complete(Order $order)
    {
        try {
            $this->orderService->complete($order);
            return redirect()->route('orders.show', $order)->with('success', 'Order marked as completed.');
        } catch (\Exception $e) {
            return redirect()->route('orders.show', $order)->with('error', $e->getMessage());
        }
    }
}
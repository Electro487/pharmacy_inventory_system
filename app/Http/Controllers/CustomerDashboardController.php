<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CustomerDashboardService;

class CustomerDashboardController extends Controller
{
    protected CustomerDashboardService $customerDashboardService;

    public function __construct(CustomerDashboardService $customerDashboardService)
    {
        $this->customerDashboardService = $customerDashboardService;
    }

    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();

        $dashboard = $this->customerDashboardService->getDashboardData($customer);

        return view('customer-auth.dashboard', compact('customer', 'dashboard'));
    }
}

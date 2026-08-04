<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterCustomerRequest;
use App\Http\Requests\LoginCustomerRequest;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function showRegister()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }

        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('customer-auth.register');
    }

    public function register(RegisterCustomerRequest $request)
    {
        try {
            $customer = $this->customerService->register($request->validated());
            Auth::guard('customer')->login($customer);
            return redirect()->route('customer.dashboard')->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            return redirect()->route('customer.register')->with('error', $e->getMessage());
        }
    }

    public function showLogin()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }

        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('customer-auth.login');
    }

    public function login(LoginCustomerRequest $request)
    {
        $credentials = $request->only('email', 'password') + ['status' => true];
        $remember = $request->boolean('remember');

        if ($this->customerService->login($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->route('customer.dashboard')->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $this->customerService->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login')->with('success', 'Logged out successfully.');
    }

}
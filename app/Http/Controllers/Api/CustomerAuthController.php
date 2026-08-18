<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterCustomerRequest;
use App\Http\Requests\LoginCustomerRequest;
use App\Services\CustomerService;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CustomerAuthController extends Controller
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Register a new customer.
     */
    public function register(RegisterCustomerRequest $request)
    {
        $customer = $this->customerService->register(
            $request->validated()
        );

        $token = $customer->createToken('customer-api-token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful.',
            'customer' => $customer,
            'token' => $token,
        ], 201);
    }

    /**
     * Log in a customer.
     */
    public function login(LoginCustomerRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password') + [
            'status' => true
        ];

        if (!$this->customerService->login($credentials, false)) {
            return response()->json([
                'message' => 'Invalid credentials.'
            ], 401);
        }

        $customer = Customer::where('email', $request->email)->first();

        $token = $customer->createToken('customer-api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'customer' => $customer,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }
}
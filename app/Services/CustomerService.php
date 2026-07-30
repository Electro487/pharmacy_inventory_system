<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerService
{
    public function getAll()
    {
        return Customer::latest()->paginate(10);
    }

    public function update(Customer $customer, array $data): Customer
    {
        $customer->update($data);
        return $customer;
    }

    public function delete(Customer $customer): void
    {
        $customer->delete();
    }

    public function register(array $data): Customer
    {
        $data['password'] = Hash::make($data['password']);
        return Customer::create($data);
    }

    public function login(array $credentials, bool $remember = false): bool
    {
        return Auth::guard('customer')->attempt($credentials, $remember);
    }

    public function logout(): void
    {
        Auth::guard('customer')->logout();
    }
}
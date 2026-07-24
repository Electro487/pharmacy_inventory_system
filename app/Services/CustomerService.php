<?php

namespace App\Services;

use App\Models\Customer;

class CustomerService
{
    public function getAll()
    {
        return Customer::latest()->paginate(10);
    }

    public function create(array $data): Customer
    {
        return Customer::create($data);
    }

    public function update(Customer $customer, array $data): Customer
    {
        $customer->update($data);
        return $customer;
    }

    public function delete(Customer $customer): void
    {
        if ($customer->id == 1) {
            return;
        }
        $customer->delete();
    }
}
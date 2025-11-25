<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function findByPhoneNumber(string $phone_number)
    {
        return Customer::where('phone_number', $phone_number)->first();
    }

    public function findByEmail(string $email)
    {
        return Customer::where('email', $email)->first();
    }

    public function create(array $data)
    {
        return Customer::create($data);
    }

    public function findOrCreate(array $data)
    {
        return Customer::firstOrCreate([
            'email' => $data['email']],
            $data
        );
    }
}

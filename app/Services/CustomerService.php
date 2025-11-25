<?php

namespace App\Services;

use App\Repositories\Contracts\CustomerRepositoryInterface;

class CustomerService
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository
    ) {}

    public function findOrCreateCustomer(array $data)
    {
        return $this->customerRepository->findOrCreate($data);
    }
}

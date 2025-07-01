<?php

namespace App\Services;

use App\Contracts\Repositories\CustomerRepositoryInterface;
use App\Contracts\Services\CustomerServiceInterface;
use App\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerService implements CustomerServiceInterface
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository
    ) {}

    /**
     * @inheritDoc
     */
    public function all(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {       
        return $this->customerRepository->all($perPage, $filters);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Customer
    {
        return $this->customerRepository->create($data);
    }
} 
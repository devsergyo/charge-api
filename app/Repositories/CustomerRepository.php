<?php

namespace App\Repositories;

use App\Contracts\Repositories\CustomerRepositoryInterface;
use App\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerRepository implements CustomerRepositoryInterface
{
   /**
     * @inheritDoc
     */
    public function all(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = Customer::query();

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        $sortBy = $filters['sort_by'] ?? 'id';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        
        $query->orderBy($sortBy, $sortDirection);
        return $query->paginate($perPage);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Customer
    {
        return Customer::create($data);
    }
} 
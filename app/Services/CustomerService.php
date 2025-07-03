<?php

namespace App\Services;

use App\Contracts\Repositories\CustomerRepositoryInterface;
use App\Contracts\Services\CustomerServiceInterface;
use App\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Exception;

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
        try {
            return $this->customerRepository->all($perPage, $filters);
        } catch (Exception $e) {
            Log::error('Erro ao listar clientes', [
                'method' => __METHOD__,
                'per_page' => $perPage,
                'filters' => $filters,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Customer
    {
        try {
            $customer = $this->customerRepository->create($data);
            
            Log::info('Cliente criado com sucesso', [
                'method' => __METHOD__,
                'customer_id' => $customer->id,
                'email' => $customer->email
            ]);
            
            return $customer;
        } catch (Exception $e) {
            Log::error('Erro ao criar cliente', [
                'method' => __METHOD__,
                'data' => $data,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
} 
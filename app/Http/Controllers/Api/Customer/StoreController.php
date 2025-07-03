<?php

namespace App\Http\Controllers\Api\Customer;

use App\Contracts\Services\CustomerServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    public function __construct(
        private CustomerServiceInterface $customerService
    ) {}

    /**
     * Cria um novo cliente
     * 
     * @param StoreCustomerRequest $request
     * @return JsonResponse
     */
    public function __invoke(StoreCustomerRequest $request): JsonResponse
    {
        $customer = $this->customerService->create($request->validated());

        return (new CustomerResource($customer))->response();
    }
} 
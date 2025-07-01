<?php

namespace App\Http\Controllers\Api\Customer;

use App\Contracts\Services\CustomerServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ListController extends Controller
{
    public function __construct(
        private CustomerServiceInterface $customerService
    ) {}

    /**
     * Lista todos os clientes com paginação
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $customers = $this->customerService->all($perPage, $request->all());

        return CustomerResource::collection($customers)->response();
    }
}

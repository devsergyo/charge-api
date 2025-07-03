<?php

namespace App\Http\Controllers\Api\Invoice;

use App\Contracts\Services\InvoiceServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ListController extends Controller
{
    public function __construct(
        private InvoiceServiceInterface $invoiceService
    ) {}

    /**
     * Lista todas as faturas de um cliente
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $customerId = $request->get('customer_id');
        
        $invoices = $this->invoiceService->findAllByCustomerId($customerId, $perPage);

        return InvoiceResource::collection($invoices)->response();
    }
}
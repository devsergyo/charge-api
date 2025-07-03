<?php

namespace App\Http\Controllers\Api\Invoice;

use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contracts\Services\InvoiceServiceInterface;

class StoreController extends Controller
{
    public function __construct(
        private InvoiceServiceInterface $invoiceService
    ) {}

    /**
     * Cria uma nova fatura
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(StoreInvoiceRequest $request): JsonResponse
    {
        $invoice = $this->invoiceService->create($request->validated());

        return InvoiceResource::make($invoice)->response();
    }
}
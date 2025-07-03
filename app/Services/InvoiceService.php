<?php

namespace App\Services;

use App\Contracts\Services\InvoiceServiceInterface;
use App\Contracts\Repositories\InvoiceRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use App\Models\Invoice;
use Exception;

class InvoiceService implements InvoiceServiceInterface
{
    public function __construct(
        private InvoiceRepositoryInterface $invoiceRepository
    ) {}
    
    /**
     * @inheritDoc
     */
    public function findAllByCustomerId(?int $customerId, int $perPage = 15): LengthAwarePaginator
    {
        try {
            $invoices = $this->invoiceRepository->findAllByCustomerId($customerId, $perPage);
            
            Log::debug('Faturas listadas com sucesso', [
                'method' => __METHOD__,
                'customer_id' => $customerId,
                'per_page' => $perPage,
                'total_found' => $invoices->total()
            ]);
            
            return $invoices;
        } catch (Exception $e) {
            Log::error('Erro ao listar faturas', [
                'method' => __METHOD__,
                'customer_id' => $customerId,
                'per_page' => $perPage,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Invoice
    {
        try {
            $invoice = $this->invoiceRepository->create($data);
            
            Log::info('Fatura criada com sucesso', [
                'method' => __METHOD__,
                'invoice_id' => $invoice->id,
                'customer_id' => $invoice->customer_id,
                'amount' => $invoice->amount,
                'due_date' => $invoice->due_date->format('Y-m-d')
            ]);
            
            return $invoice;
        } catch (Exception $e) {
            Log::error('Erro ao criar fatura', [
                'method' => __METHOD__,
                'data' => $data,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
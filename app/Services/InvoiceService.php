<?php

namespace App\Services;

use App\Contracts\Services\InvoiceServiceInterface;
use App\Contracts\Repositories\InvoiceRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use App\Models\Invoice;
use Exception;
use Illuminate\Support\Facades\Cache;

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
            $cacheKey = 'invoices_' . $customerId . '_' . $perPage;

            if (Cache::has($cacheKey)) {

                $cachedInvoices = Cache::get($cacheKey);
                Log::debug('Faturas listadas do cache com sucesso', [
                    'method' => __METHOD__,
                    'customer_id' => $customerId,
                    'per_page' => $perPage,
                    'total_found' => $cachedInvoices->total()
                ]);
                return $cachedInvoices;
            }

            $invoices = $this->invoiceRepository->findAllByCustomerId($customerId, $perPage);
            
            // Salvar no cache por 30 minutos
            Cache::put($cacheKey, $invoices, now()->addMinutes(30));
            
            Log::debug('Faturas listadas do banco de dados e salvas no cache com sucesso', [
                'method' => __METHOD__,
                'customer_id' => $customerId,
                'per_page' => $perPage,
                'total_found' => $invoices->total(),
                'cache_key' => $cacheKey,
                'cache_ttl' => '30 minutes'
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
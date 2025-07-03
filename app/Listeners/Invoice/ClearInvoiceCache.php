<?php

namespace App\Listeners\Invoice;

use App\Events\Invoice\InvoiceCreated;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ClearInvoiceCache
{
    /**
     * Handle the event.
     */
    public function handle(InvoiceCreated $event): void
    {
        $invoice = $event->invoice;
        $customerId = $invoice->customer_id;
        
        $this->clearCustomerCache($customerId);
        
        Log::info('Cache de faturas limpo automaticamente', [
            'event' => class_basename($event),
            'invoice_id' => $invoice->id,
            'customer_id' => $customerId
        ]);
    }

    /**
     * Limpa o cache relacionado a um customer específico
     */
    private function clearCustomerCache(int $customerId): void
    {
        try {
            // Limpar cache para diferentes per_page
            $perPages = [15, 25, 50, 100];
            
            foreach ($perPages as $perPage) {
                $cacheKey = 'invoices_' . $customerId . '_' . $perPage;
                Cache::forget($cacheKey);
            }
            
            Log::debug('Cache limpo para customer', [
                'method' => __METHOD__,
                'customer_id' => $customerId,
                'cleared_keys' => array_map(fn($pp) => 'invoices_' . $customerId . '_' . $pp, $perPages)
            ]);
        } catch (\Exception $e) {
            Log::warning('Erro ao limpar cache do customer', [
                'method' => __METHOD__,
                'customer_id' => $customerId,
                'error' => $e->getMessage()
            ]);
        }
    }
} 
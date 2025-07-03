<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\InvoiceRepositoryInterface;
use App\Models\Invoice;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendInvoiceNotificationJob;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findAllByCustomerId(?int $customerId, int $perPage = 15): LengthAwarePaginator
    {
        $query = Invoice::query();

        if ($customerId) {
            $query->where('customer_id', $customerId);
        }
        
        return $query->paginate($perPage);
    }  

    /**
     * @inheritDoc
     */
    public function create(array $data): Invoice
    {
        DB::beginTransaction();
        try {
            $invoice = Invoice::create($data);

            SendInvoiceNotificationJob::dispatch($invoice);

            DB::commit();
            return $invoice;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\InvoiceRepositoryInterface;
use App\Models\Invoice;
use Illuminate\Pagination\LengthAwarePaginator;

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
        return Invoice::create($data);
    }
}
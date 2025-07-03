<?php

namespace App\Services;

use App\Contracts\Services\InvoiceServiceInterface;
use App\Contracts\Repositories\InvoiceRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Invoice;

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
        return $this->invoiceRepository->findAllByCustomerId($customerId, $perPage);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Invoice
    {
        return $this->invoiceRepository->create($data);
    }
}
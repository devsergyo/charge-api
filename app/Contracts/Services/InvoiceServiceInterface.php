<?php

namespace App\Contracts\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Invoice;

interface InvoiceServiceInterface
{
    /**
     * Retorna todas as faturas de um cliente
     * 
     * @param int|null $customerId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function findAllByCustomerId(?int $customerId, int $perPage = 15): LengthAwarePaginator;

    /**
     * Cria uma nova fatura
     * 
     * @param array $data
     * @return Invoice
     */
    public function create(array $data): Invoice;
}
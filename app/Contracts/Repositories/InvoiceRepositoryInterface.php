<?php

namespace App\Contracts\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Invoice;

interface InvoiceRepositoryInterface
{
    /**
     * Retorna todas as faturas de um cliente
     * 
     * @param int $customerId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function findAllByCustomerId(int $customerId, int $perPage = 15): LengthAwarePaginator;

    /**
     * Cria uma nova fatura
     * 
     * @param array $data
     * @return Invoice
     */
    public function create(array $data): Invoice;
}
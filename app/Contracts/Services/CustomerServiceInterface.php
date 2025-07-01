<?php

namespace App\Contracts\Services;

use App\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;

interface CustomerServiceInterface
{
    /**
     * Lista todos os clientes com paginação
     * 
     * @param int $perPage Número de itens por página
     * @param array $filters Filtros opcionais para a busca
     * @return LengthAwarePaginator
     */
    public function all(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    /**
     * Cria um novo cliente
     * 
     * @param array $data Dados do cliente
     * @return Customer
     */
    public function create(array $data): Customer;

} 
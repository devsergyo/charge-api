<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Scopes\Searchable;

class Customer extends Model
{
    use HasFactory, Searchable;

    /**
     * Campos que podem ser pesquisados
     * 
     * @var array
     */
    protected array $searchableFields = [
        'first_name',
        'last_name',
        'email',
        'inscription',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'inscription',
        'email',
    ];

    /**
     * Formata o firstName como primeiro nome
     * 
     * @return Attribute
     */
    protected function firstName(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ucfirst(mb_strtolower($value)),
            get: fn($value) => ucfirst(mb_strtolower($value)),
        );
    }

    /**
     * Formata o lastName como último nome
     * 
     * @return Attribute
     */
    protected function lastName(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ucfirst(mb_strtolower($value)),
            get: fn($value) => ucfirst(mb_strtolower($value)),
        );
    }

    /**
     * Formata o inscription como CPF ou CNPJ
     * 
     * @return Attribute
     */
    protected function inscription(): Attribute
    {
        return Attribute::make(
            set: fn($value) => preg_replace('/\D/', '', $value),
            get: function ($value) {
                $value = preg_replace('/\D/', '', $value);
                if (strlen($value) === 11) {
                    return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $value);
                }
                if (strlen($value) === 14) {
                    return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $value);
                }
                return $value;
            },
        );
    }
    /**
     * Retorna o nome completo do cliente
     * 
     * @return Attribute
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->first_name} {$this->last_name}",
        );
    }
}

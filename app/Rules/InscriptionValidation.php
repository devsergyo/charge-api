<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class InscriptionValidation implements ValidationRule
{
    /**
     * Executa a regra de validação.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $cleanValue = preg_replace('/\D/', '', $value ?? '');
        
        if (strlen($cleanValue) !== 11 && strlen($cleanValue) !== 14) {
            $fail('O CPF/CNPJ deve ter 11 dígitos (CPF) ou 14 dígitos (CNPJ).');
        }
    }
}

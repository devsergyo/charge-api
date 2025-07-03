<?php

namespace App\Http\Requests\Customer;

use App\Rules\InscriptionValidation;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:customers,email', 'max:255'],
            'inscription' => ['required', 'string', 'unique:customers,inscription', new InscriptionValidation()],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'O primeiro nome é obrigatório.',
            'first_name.string' => 'O primeiro nome deve ser um texto.',
            'first_name.max' => 'O primeiro nome não pode ter mais de 255 caracteres.',
            
            'last_name.required' => 'O último nome é obrigatório.',
            'last_name.string' => 'O último nome deve ser um texto.',
            'last_name.max' => 'O último nome não pode ter mais de 255 caracteres.',
            
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ter um formato válido.',
            'email.unique' => 'Este email já está cadastrado.',
            'email.max' => 'O email não pode ter mais de 255 caracteres.',
            
            'inscription.required' => 'O CPF/CNPJ é obrigatório.',
            'inscription.string' => 'O CPF/CNPJ deve ser um texto.',
            'inscription.unique' => 'Este CPF/CNPJ já está cadastrado.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('inscription')) {
            $this->merge([
                'inscription' => preg_replace('/\D/', '', $this->inscription),
            ]);
        }
    }
} 
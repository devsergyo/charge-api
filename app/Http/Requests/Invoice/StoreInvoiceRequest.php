<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0'],
            'customer_id' => ['required', 'exists:customers,id'],
            'due_date' => ['required', 'date', 'after_or_equal:today'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'O valor da cobrança é obrigatório.',
            'amount.numeric' => 'O valor da cobrança deve ser um número.',
            'amount.min' => 'O valor da cobrança não pode ser negativo.',
            
            'customer_id.required' => 'O cliente é obrigatório.',
            'customer_id.exists' => 'O cliente selecionado não existe.',
            
            'due_date.required' => 'A data de vencimento é obrigatória.',
            'due_date.date' => 'A data de vencimento deve ser uma data válida.',
            'due_date.after_or_equal' => 'A data de vencimento não pode ser anterior à data atual.',
            
            'description.string' => 'A descrição deve ser um texto válido.',
        ];
    }

    public function attributes(): array
    {
        return [
            'amount' => 'valor',
            'customer_id' => 'cliente',
            'due_date' => 'data de vencimento',
            'description' => 'descrição',
        ];
    }
}

<?php

namespace Tests\Unit\Http\Requests\Invoice;

use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StoreInvoiceRequestTest extends TestCase
{
    use RefreshDatabase;

    private StoreInvoiceRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new StoreInvoiceRequest();
    }

    /**
     * Testa se a validação aceita dados válidos de cobrança
     */
    public function testShouldValidateValidInvoiceData(): void
    {
        $customer = Customer::factory()->create();
        $data = [
            'amount' => 100.50,
            'customer_id' => $customer->id,
            'due_date' => now()->addDay()->format('Y-m-d'),
            'description' => 'Cobrança de teste',
        ];
        $validator = Validator::make($data, $this->request->rules(), $this->request->messages());
        $this->assertTrue($validator->passes());
    }

    /**
     * Testa se a validação rejeita dados inválidos de cobrança
     */
    public function testShouldRejectInvalidInvoiceData(): void
    {
        $data = [
            'amount' => -10,
            'customer_id' => 9999, // não existe
            'due_date' => 'ontem',
            'description' => 12345,
        ];
        $validator = Validator::make($data, $this->request->rules(), $this->request->messages());
        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('amount'));
        $this->assertTrue($validator->errors()->has('customer_id'));
        $this->assertTrue($validator->errors()->has('due_date'));
        $this->assertTrue($validator->errors()->has('description'));
    }

    /**
     * Testa se as mensagens de erro customizadas são retornadas corretamente
     */
    public function testShouldReturnCustomErrorMessage(): void
    {
        $data = [
            'amount' => null,
            'customer_id' => null,
            'due_date' => null,
        ];
        $validator = Validator::make($data, $this->request->rules(), $this->request->messages());
        $this->assertContains('O valor da cobrança é obrigatório.', $validator->errors()->get('amount'));
        $this->assertContains('O cliente é obrigatório.', $validator->errors()->get('customer_id'));
        $this->assertContains('A data de vencimento é obrigatória.', $validator->errors()->get('due_date'));
    }

    /**
     * Testa se a requisição está autorizada
     */
    public function testShouldAuthorizeRequest(): void
    {
        $this->assertTrue($this->request->authorize());
    }
} 
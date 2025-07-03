<?php

namespace Tests\Unit\Http\Requests\Customer;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StoreCustomerRequestTest extends TestCase
{
    use RefreshDatabase;

    private StoreCustomerRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new StoreCustomerRequest();
    }

    /**
     * Testa se os dados válidos passam na validação do request de cliente.
     *
     * Este teste garante que um payload válido é aceito pela validação.
     */
    public function testShouldValidateValidCustomerData(): void
    {
        $data = [
            'first_name' => 'João',
            'last_name' => 'Silva',
            'email' => 'joao@exemplo.com',
            'inscription' => '12345678901',
        ];
        $validator = Validator::make($data, $this->request->rules(), $this->request->messages());
        $this->assertTrue($validator->passes());
    }

    /**
     * Testa se dados inválidos são rejeitados pela validação do request de cliente.
     *
     * Este teste cobre campos obrigatórios, formato de email e inscrição inválida.
     */
    public function testShouldRejectInvalidCustomerData(): void
    {
        $data = [
            'first_name' => '',
            'last_name' => '',
            'email' => 'email-invalido',
            'inscription' => '123',
        ];
        $validator = Validator::make($data, $this->request->rules(), $this->request->messages());
        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('first_name'));
        $this->assertTrue($validator->errors()->has('last_name'));
        $this->assertTrue($validator->errors()->has('email'));
        $this->assertTrue($validator->errors()->has('inscription'));
    }

    /**
     * Testa se as mensagens customizadas de erro são retornadas corretamente.
     *
     * Este teste garante que as mensagens definidas no método messages() são usadas.
     */
    public function testShouldReturnCustomErrorMessage(): void
    {
        $data = [
            'first_name' => null,
            'last_name' => null,
            'email' => null,
            'inscription' => null,
        ];
        $validator = Validator::make($data, $this->request->rules(), $this->request->messages());
        $this->assertContains('O primeiro nome é obrigatório.', $validator->errors()->get('first_name'));
        $this->assertContains('O último nome é obrigatório.', $validator->errors()->get('last_name'));
        $this->assertContains('O email é obrigatório.', $validator->errors()->get('email'));
        $this->assertContains('O CPF/CNPJ é obrigatório.', $validator->errors()->get('inscription'));
    }

    /**
     * Testa se o método authorize permite a requisição.
     *
     * Este teste garante que a autorização está liberada para o request.
     */
    public function testShouldAuthorizeRequest(): void
    {
        $this->assertTrue($this->request->authorize());
    }
} 
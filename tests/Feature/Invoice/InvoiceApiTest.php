<?php

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Testa o endpoint de listagem de cobranças
 */
test('should list invoices successfully', function () {
    $customer = Customer::factory()->create();
    $invoices = Invoice::factory()->count(3)->create(['customer_id' => $customer->id]);

    $response = $this->getJson('/api/v1/invoices');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'customer_id',
                    'amount',
                    'due_date',
                    'description'
                ]
            ]
        ]);
});

/**
 * Testa o endpoint de criação de cobrança com dados válidos
 */
test('should create invoice with valid data', function () {
    $customer = Customer::factory()->create();
    $data = [
        'amount' => 150.75,
        'customer_id' => $customer->id,
        'due_date' => now()->addDays(30)->format('Y-m-d'),
        'description' => 'Cobrança de teste'
    ];

    $response = $this->postJson('/api/v1/invoices', $data);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'data' => [
                'customer_id',
                'amount',
                'due_date',
                'description'
            ]
        ])
        ->assertJson([
            'data' => [
                'customer_id' => $customer->id,
                'amount' => '150.75',
                'description' => 'Cobrança de teste'
            ]
        ]);

    $this->assertDatabaseHas('invoices', [
        'amount' => 150.75,
        'customer_id' => $customer->id,
        'description' => 'Cobrança de teste'
    ]);
});

/**
 * Testa o endpoint de criação de cobrança com dados inválidos
 */
test('should reject invoice creation with invalid data', function () {
    $data = [
        'amount' => -10,
        'customer_id' => 9999, // cliente inexistente
        'due_date' => 'data-invalida',
        'description' => 12345
    ];

    $response = $this->postJson('/api/v1/invoices', $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['amount', 'customer_id', 'due_date', 'description']);
});

/**
 * Testa o endpoint de criação de cobrança com cliente inexistente
 */
test('should reject invoice creation with non-existent customer', function () {
    $data = [
        'amount' => 100.00,
        'customer_id' => 9999,
        'due_date' => now()->addDays(30)->format('Y-m-d'),
        'description' => 'Cobrança de teste'
    ];

    $response = $this->postJson('/api/v1/invoices', $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['customer_id']);
});

/**
 * Testa o endpoint de criação de cobrança com data de vencimento no passado
 */
test('should reject invoice creation with past due date', function () {
    $customer = Customer::factory()->create();
    $data = [
        'amount' => 100.00,
        'customer_id' => $customer->id,
        'due_date' => now()->subDays(1)->format('Y-m-d'),
        'description' => 'Cobrança de teste'
    ];

    $response = $this->postJson('/api/v1/invoices', $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['due_date']);
}); 
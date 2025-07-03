<?php

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Testa o endpoint de listagem de clientes
 */
test('should list customers successfully', function () {
    $customers = Customer::factory()->count(3)->create();

    $response = $this->getJson('/api/v1/customers');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'full_name',
                    'email',
                    'inscription',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
});

/**
 * Testa o endpoint de criação de cliente com dados válidos
 */
test('should create customer with valid data', function () {
    $data = [
        'first_name' => 'João',
        'last_name' => 'Silva',
        'email' => 'joao@example.com',
        'inscription' => '12345678901'
    ];

    $response = $this->postJson('/api/v1/customers', $data);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'data' => [
                'id',
                'first_name',
                'last_name',
                'full_name',
                'email',
                'inscription',
                'created_at',
                'updated_at'
            ]
        ])
        ->assertJson([
            'data' => [
                'first_name' => 'João',
                'last_name' => 'Silva',
                'email' => 'joao@example.com',
                'inscription' => '123.456.789-01'
            ]
        ]);

    $this->assertDatabaseHas('customers', [
        'first_name' => 'João',
        'last_name' => 'Silva',
        'email' => 'joao@example.com',
        'inscription' => '12345678901'
    ]);
});

/**
 * Testa o endpoint de criação de cliente com dados inválidos
 */
test('should reject customer creation with invalid data', function () {

    $data = [
        'first_name' => '',
        'last_name' => '',
        'email' => 'email-invalido',
        'inscription' => '123'
    ];

    $response = $this->postJson('/api/v1/customers', $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'inscription']);
});

/**
 * Testa o endpoint de criação de cliente com email duplicado
 */
test('should reject customer creation with duplicate email', function () {

    Customer::factory()->create(['email' => 'joao@example.com']);

    $data = [
        'first_name' => 'João',
        'last_name' => 'Silva',
        'email' => 'joao@example.com',
        'inscription' => '12345678901'
    ];

    $response = $this->postJson('/api/v1/customers', $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
}); 
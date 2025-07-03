<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'amount' => $this->faker->randomFloat(2, 50, 5000),
            'due_date' => $this->faker->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
            'description' => $this->faker->sentence(6),
        ];
    }

    /**
     * Configura a factory para usar um customer específico
     */
    public function forCustomer(int $customerId): static
    {
        return $this->state(fn (array $attributes) => [
            'customer_id' => $customerId,
        ]);
    }

    /**
     * Configura a factory para faturas vencidas
     */
    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'due_date' => $this->faker->dateTimeBetween('-6 months', '-1 day')->format('Y-m-d'),
        ]);
    }
}

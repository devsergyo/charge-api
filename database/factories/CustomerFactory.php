<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $inscription = fake()->boolean() ? $this->generateCpfCnpj(11) : $this->generateCpfCnpj(14);

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'inscription' => $inscription,
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }

    private function generateCpfCnpj($length = 11) {
            $cpfCnpj = '';
            for ($i = 0; $i < $length; $i++) {
                $cpfCnpj .= random_int(0, 9);
            }
            
            if ($length === 11) {
                return Str::of($cpfCnpj)
                    ->substr(0, 3) . '.' .
                    Str::of($cpfCnpj)->substr(3, 3) . '.' .
                    Str::of($cpfCnpj)->substr(6, 3) . '-' .
                    Str::of($cpfCnpj)->substr(9, 2);
            }
            
            if ($length === 14) {
                return Str::of($cpfCnpj)
                    ->substr(0, 2) . '.' .
                    Str::of($cpfCnpj)->substr(2, 3) . '.' .
                    Str::of($cpfCnpj)->substr(5, 3) . '/' .
                    Str::of($cpfCnpj)->substr(8, 4) . '-' .
                    Str::of($cpfCnpj)->substr(12, 2);
            }

            return $cpfCnpj;
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_client' => 'John Doe',
            'cpf' => '12345678909',
            'description' => 'Payment for services',
            'amount' => 100.99,
            'payment_method' => 'pix'
        ];
    }
}

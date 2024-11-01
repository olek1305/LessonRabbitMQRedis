<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = $this->faker->numberBetween(10, 1000);

        return [
            'product_title' => $this->faker->word(),
            'price' => $price,
            'quantity' => $this->faker->numberBetween(1, 10),
            'influencer_revenue' => 0.1 * $price,
            'admin_revenue' => 0.9 * $price,
        ];
    }
}

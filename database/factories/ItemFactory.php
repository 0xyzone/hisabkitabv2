<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'image' => null,
            'payout_price' => fake()->randomFloat(2, 50, 1500),
            'unit' => fake()->randomElement(['per piece', 'per box', 'per dozen', 'per kg']),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}

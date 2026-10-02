<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\ItemReturn;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ItemReturn>
 */
class ItemReturnFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 100);
        $unitPrice = fake()->randomFloat(2, 50, 500);

        return [
            'vendor_id' => Vendor::factory(),
            'item_id' => Item::factory(),
            'quantity' => $quantity,
            'unit_payout_price' => $unitPrice,
            'total_payout' => round($quantity * $unitPrice, 2),
            'return_date' => fake()->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
            'reference_number' => 'RET-'.fake()->numerify('#####'),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}

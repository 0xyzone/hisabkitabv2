<?php

namespace Database\Factories;

use App\Models\Vendor;
use App\Models\VendorPayment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VendorPayment>
 */
class VendorPaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vendor_id' => Vendor::factory(),
            'amount' => fake()->randomFloat(2, 500, 10000),
            'payment_date' => fake()->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
            'payment_method' => fake()->randomElement(['cash', 'bank_transfer', 'cheque', 'digital_wallet']),
            'reference_number' => 'TXN-'.fake()->numerify('######'),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}

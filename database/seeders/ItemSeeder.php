<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Cotton Casual Shirt',
                'payout_price' => 350.00,
                'unit' => 'per piece',
                'description' => '100% cotton premium casual shirts',
                'is_active' => true,
            ],
            [
                'name' => 'Denim Jeans Pant',
                'payout_price' => 650.00,
                'unit' => 'per piece',
                'description' => 'Slim fit stretchable denim jeans',
                'is_active' => true,
            ],
            [
                'name' => 'Woolen Winter Jacket',
                'payout_price' => 1200.00,
                'unit' => 'per piece',
                'description' => 'Heavy winter padded warm jacket',
                'is_active' => true,
            ],
            [
                'name' => 'Cotton Socks Pack (3 Pairs)',
                'payout_price' => 120.00,
                'unit' => 'per pack',
                'description' => 'Breathable ankle socks pack',
                'is_active' => true,
            ],
            [
                'name' => 'Leather Wallet',
                'payout_price' => 280.00,
                'unit' => 'per piece',
                'description' => 'Genuine leather bi-fold wallet',
                'is_active' => true,
            ],
        ];

        foreach ($items as $item) {
            Item::firstOrCreate(['name' => $item['name']], $item);
        }
    }
}

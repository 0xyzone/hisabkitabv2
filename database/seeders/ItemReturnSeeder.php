<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemReturn;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class ItemReturnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendor1 = Vendor::first();
        $shirt = Item::where('name', 'Cotton Casual Shirt')->first();
        $jeans = Item::where('name', 'Denim Jeans Pant')->first();

        if ($vendor1 && $shirt) {
            ItemReturn::firstOrCreate(
                ['reference_number' => 'RET-2026-001'],
                [
                    'vendor_id' => $vendor1->id,
                    'item_id' => $shirt->id,
                    'quantity' => 20,
                    'unit_payout_price' => $shirt->payout_price,
                    'total_payout' => 20 * (float) $shirt->payout_price,
                    'return_date' => now()->subDays(10)->toDateString(),
                    'notes' => 'Minor size mismatch on shipment batch A',
                ]
            );
        }

        if ($vendor1 && $jeans) {
            ItemReturn::firstOrCreate(
                ['reference_number' => 'RET-2026-002'],
                [
                    'vendor_id' => $vendor1->id,
                    'item_id' => $jeans->id,
                    'quantity' => 15,
                    'unit_payout_price' => $jeans->payout_price,
                    'total_payout' => 15 * (float) $jeans->payout_price,
                    'return_date' => now()->subDays(5)->toDateString(),
                    'notes' => 'Excess unsold stock returned for credit',
                ]
            );
        }
    }
}

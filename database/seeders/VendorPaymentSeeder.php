<?php

namespace Database\Seeders;

use App\Models\Vendor;
use App\Models\VendorPayment;
use Illuminate\Database\Seeder;

class VendorPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendor1 = Vendor::first();

        if ($vendor1) {
            VendorPayment::firstOrCreate(
                ['reference_number' => 'TXN-BANK-89021'],
                [
                    'vendor_id' => $vendor1->id,
                    'amount' => 10000.00,
                    'payment_date' => now()->subDays(2)->toDateString(),
                    'payment_method' => 'bank_transfer',
                    'notes' => 'Partial settlement for returns RET-2026-001 and 002',
                ]
            );
        }
    }
}

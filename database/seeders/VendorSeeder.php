<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = [
            [
                'name' => 'Kathmandu Garments & Supplies',
                'phone' => '+977-9841234567',
                'email' => 'sales@ktmgarments.com',
                'address' => 'New Road, Kathmandu',
                'notes' => 'Primary clothing and textile supplier',
            ],
            [
                'name' => 'Apex Apparel Works',
                'phone' => '+977-9801987654',
                'email' => 'contact@apexapparel.com',
                'address' => 'Patan Industrial Estate, Lalitpur',
                'notes' => 'Jackets and outerwear vendor',
            ],
            [
                'name' => 'Himalayan Leather Crafts',
                'phone' => '+977-9851020304',
                'email' => 'info@himalayanleather.com',
                'address' => 'Thamel, Kathmandu',
                'notes' => 'Belts, wallets, and accessories vendor',
            ],
        ];

        foreach ($vendors as $vendor) {
            Vendor::firstOrCreate(['name' => $vendor['name']], $vendor);
        }
    }
}

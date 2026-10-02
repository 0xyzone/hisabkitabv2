<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\ItemReturn;
use App\Models\Vendor;
use App\Models\VendorPayment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_can_be_created_with_name_image_payout_price_and_unit(): void
    {
        $item = Item::create([
            'name' => 'Cotton Polo T-Shirt',
            'image' => 'items/polo-tshirt.png',
            'payout_price' => 450.50,
            'unit' => 'per piece',
            'description' => 'Comfort fit summer polo shirt',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'name' => 'Cotton Polo T-Shirt',
            'image' => 'items/polo-tshirt.png',
            'payout_price' => 450.50,
            'unit' => 'per piece',
        ]);

        $this->assertEquals('per piece', $item->unit);
        $this->assertEquals(450.50, (float) $item->payout_price);
    }

    public function test_item_return_calculates_total_payout_according_to_quantity_sent(): void
    {
        $item = Item::create([
            'name' => 'Denim Pants',
            'payout_price' => 500.00,
            'unit' => 'per piece',
        ]);

        $vendor = Vendor::create([
            'name' => 'Test Vendor Supplies',
        ]);

        $return = ItemReturn::create([
            'vendor_id' => $vendor->id,
            'item_id' => $item->id,
            'quantity' => 12,
            'unit_payout_price' => 500.00,
            'return_date' => now()->toDateString(),
        ]);

        // 12 pieces * Rs. 500 = Rs. 6000
        $this->assertEquals(6000.00, (float) $return->total_payout);
        $this->assertDatabaseHas('item_returns', [
            'id' => $return->id,
            'quantity' => 12,
            'unit_payout_price' => 500.00,
            'total_payout' => 6000.00,
        ]);
    }

    public function test_item_return_recalculates_total_payout_when_quantity_is_updated(): void
    {
        $item = Item::create([
            'name' => 'Wool Sweater',
            'payout_price' => 700.00,
            'unit' => 'per piece',
        ]);

        $return = ItemReturn::create([
            'item_id' => $item->id,
            'quantity' => 5,
            'unit_payout_price' => 700.00,
            'return_date' => now()->toDateString(),
        ]);

        $this->assertEquals(3500.00, (float) $return->total_payout);

        $return->quantity = 8;
        $return->save();

        $this->assertEquals(5600.00, (float) $return->fresh()->total_payout);
    }

    public function test_vendor_payment_records_received_amount_and_method(): void
    {
        $vendor = Vendor::create([
            'name' => 'Textile Hub Ltd',
            'phone' => '1234567890',
        ]);

        $payment = VendorPayment::create([
            'vendor_id' => $vendor->id,
            'amount' => 15000.00,
            'payment_date' => now()->toDateString(),
            'payment_method' => 'bank_transfer',
            'reference_number' => 'REF-998811',
            'notes' => 'Settlement for batch returns',
        ]);

        $this->assertDatabaseHas('vendor_payments', [
            'id' => $payment->id,
            'vendor_id' => $vendor->id,
            'amount' => 15000.00,
            'payment_method' => 'bank_transfer',
        ]);

        $this->assertEquals($vendor->id, $payment->vendor->id);
    }

    public function test_stats_widget_computes_correct_totals(): void
    {
        $item = Item::create([
            'name' => 'Casual Cap',
            'payout_price' => 200.00,
            'unit' => 'per piece',
        ]);

        $vendor = Vendor::create(['name' => 'Cap Vendor']);

        ItemReturn::create([
            'vendor_id' => $vendor->id,
            'item_id' => $item->id,
            'quantity' => 10,
            'unit_payout_price' => 200.00,
            'return_date' => now()->toDateString(),
        ]);

        VendorPayment::create([
            'vendor_id' => $vendor->id,
            'amount' => 1500.00,
            'payment_date' => now()->toDateString(),
            'payment_method' => 'cash',
        ]);

        $totalPayout = (float) ItemReturn::sum('total_payout');
        $totalReceived = (float) VendorPayment::sum('amount');
        $outstanding = $totalPayout - $totalReceived;

        $this->assertEquals(2000.00, $totalPayout);
        $this->assertEquals(1500.00, $totalReceived);
        $this->assertEquals(500.00, $outstanding);
    }
}

<?php

namespace App\Models;

use Database\Factories\ItemReturnFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemReturn extends Model
{
    /** @use HasFactory<ItemReturnFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'vendor_id',
        'item_id',
        'quantity',
        'unit_payout_price',
        'total_payout',
        'return_date',
        'reference_number',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'unit_payout_price' => 'decimal:2',
            'total_payout' => 'decimal:2',
            'return_date' => 'date',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function booted(): void
    {
        static::saving(function (ItemReturn $itemReturn): void {
            if ($itemReturn->quantity !== null && $itemReturn->unit_payout_price !== null) {
                $itemReturn->total_payout = round((float) $itemReturn->quantity * (float) $itemReturn->unit_payout_price, 2);
            }
        });
    }

    /**
     * @return BelongsTo<Vendor, $this>
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * @return BelongsTo<Item, $this>
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}

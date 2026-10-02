<?php

namespace App\Models;

use Database\Factories\VendorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    /** @use HasFactory<VendorFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'notes',
    ];

    /**
     * @return HasMany<ItemReturn, $this>
     */
    public function itemReturns(): HasMany
    {
        return $this->hasMany(ItemReturn::class);
    }

    /**
     * @return HasMany<VendorPayment, $this>
     */
    public function vendorPayments(): HasMany
    {
        return $this->hasMany(VendorPayment::class);
    }
}

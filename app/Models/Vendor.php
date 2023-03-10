<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'telephone',
        'description',
    ];

    /**
     * Get the purchase bills for the vendor.
     */
    public function purchaseBills(): HasMany
    {
        return $this->hasMany(PurchaseBill::class);
    }
}

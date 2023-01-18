<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinishProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'labour_percentage',
        'sales_price',
    ];

    /**
     * Get the raw products for the finish product.
     */
    public function rawProducts(): BelongsToMany
    {
        return $this->belongsToMany(RawProduct::class);
    }
}

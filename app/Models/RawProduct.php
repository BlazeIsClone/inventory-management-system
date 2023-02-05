<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RawProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'unit',
        'available_quantity',
    ];

    /**
     * Get the finished products belongs to raw products.
     */
    public function finshProducts(): BelongsToMany
    {
        return $this->belongsToMany(FinishProduct::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Production extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'finish_product_id',
        'quantity',
    ];

    /**
     * Get the finish product for the production.
     */
    public function finishProduct(): BelongsTo
    {
        return $this->belongsTo(FinishProduct::class);
    }
}

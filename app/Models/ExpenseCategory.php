<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ExpenseCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'is_included_in_total_expenses',
    ];

    /**
     * Get the expense of the exepense category.
     */
    public function expense(): HasOne
    {
        return $this->hasOne(Expense::class);
    }
}

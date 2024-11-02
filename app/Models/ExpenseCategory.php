<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpenseCategory extends Model
{
    use HasFactory;
    protected $table = 'expenses_categories';
    protected $fillable = [
        'name',
        'parent_id',
        'level'
    ];


    /**
     * Get the user that owns the ExpenseCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'parent_id');
    }

    /* Relación con las subcategorías.    
     * Get all of the comments for the ExpenseCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(ExpenseCategory::class, 'parent_id');
    }

    /**
     * Get all of the comments for the ExpenseCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subchildren(): HasMany
    {
        return $this->hasMany(ExpenseCategory::class, 'parent_id');
    }
}

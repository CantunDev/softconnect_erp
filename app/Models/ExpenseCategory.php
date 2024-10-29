<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;
    protected $table = 'expenses_categories';
    protected $fillable = [
        'name',
        'parent_id',
        'level'
    ];

    public function parent()
    {
        return $this->belongsTo($this, 'parent_id');
    }

    /**
     * Relación con las subcategorías.
     */
    public function children()
    {
        return $this->hasMany($this, 'parent_id');
    }
}

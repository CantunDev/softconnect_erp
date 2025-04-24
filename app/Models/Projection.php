<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Projection extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "projections";
    protected $fillable = [
        'restaurant_id', 
        'year',
        'month',
        'projected_sales', 
        'actual_sales',
        'projected_costs',
        'actual_costs',
        'projected_profit',
        'actual_profit',
        'projected_tax',
        'actual_tax',
        'projected_check',
        'actual_check',
    ];

    /**
     * Scope para filtrar por restaurant
     */
    public function scopeForRestaurant($query, $restaurant)
    {
        return $query->where('restaurant_id', $restaurant);
    }
    /**
     * Scope para filtrar por año y mes
     */
    public function scopeForDate($query, $year, $month)
    {
        return $query->where('year', $year)->where('month', $month);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProjectionDay extends Model
{
    protected $table = 'projections_days';
    protected $fillable = [
        'date',
        'projection_id',
        'restaurant_id',
        'user_id',
        'projected_day_sales',
        'actual_day_sales',
        'projected_day_costs',
        'actual_day_costs',
        'projected_day_profit',
        'actual_day_profit',
        'projected_day_tax',
        'actual_day_tax',
        'projected_day_check',
        'actual_day_check',
        'status'
    ];

    public $timestamps = false;

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
        return $query->whereYear('date', $year)
            ->whereMonth('date', $month);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessRestaurants extends Model
{
    use HasFactory;

    protected $table = "business_restaurants";
    protected $fillable = [
        'business_id',
        'restaurant_id'
    ];

    /**
     * Get all of the comments for the BusinessRestaurants
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function restaurants(): HasMany
    // {
    //     return $this->hasMany(Restaurant::class, 'id','restaurant_id');
    // }

    /**
     * Get the user that owns the BusinessRestaurants
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function restaurants(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }
}

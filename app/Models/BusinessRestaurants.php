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

    //  protected $appends = ['getBusiness'];

    /**
     * Get all of the comments for the BusinessRestaurants
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
     public function restaurants(): BelongsTo
     {
        return $this->belongsTo(Restaurant::class, 'restaurant_id','id');
     }

    /**
     * Get the user that owns the BusinessRestaurants
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // public function getRestaurant(): BelongsTo
    // {
    //     return $this->belongsTo(Restaurant::class,  'id', 'restaurant_id');
    // }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }

}

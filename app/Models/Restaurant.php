<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "restaurants";
    protected $fillable = [
        'name', 
        'description',
        'ip',
        'database', 
        'restaurant_file'
    ];
    public function scopeUnassigned($query, $businessId)
    {
        return $query->where(function ($q) use ($businessId) {
            $q->doesntHave('business');
        })->orWhereHas('business', function ($q) use ($businessId) {
            $q->where('id', $businessId);
        });
    }

    /**
     * Get the user associated with the Restaurant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function business()
    {
        return $this->hasOneThrough(Business::class,BusinessRestaurants::class,'restaurant_id','id','id','business_id');
    }

    /**
        * The roles that belong to the Restaurant
        *
        * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
        */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_restaurants', 'restaurant_id', 'user_id');
    }
}

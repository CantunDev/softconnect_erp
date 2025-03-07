<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;


class Business extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "business";
    protected $fillable = [
        'name', 'business_name', 'business_address', 'rfc', 'telephone', 'business_line', 'email', 'web', 'country', 'state', 'city', 'regime', 'business_file', 'idregiment_sat',
        'color_primary',
        'color_secondary',
        'color_accent',
        'slug'
    ];

    protected static function boot()
    {
        parent::boot();

        // Generar automáticamente el slug al crear un negocio
        static::saving(function ($business) {
            if ($business->isDirty('name') || empty($business->slug)) {
                $business->slug = Str::slug($business->name);
            }
        });
    }

    // Obtener el negocio por slug en lugar de ID
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_business', 'business_id', 'user_id');
    }

    public function business_restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'business_restaurants', 'business_id', 'restaurant_id');
    }

    public function restaurants()
    {
        return $this->hasManyThrough(Restaurant::class,BusinessRestaurants::class,'business_id','id','id','restaurant_id');
    }
}

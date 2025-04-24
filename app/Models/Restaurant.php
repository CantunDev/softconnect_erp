<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;
use \Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

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
        'restaurant_file',
        'color_primary',
        'color_secondary',
        'color_accent',
        'slug'
    ];

    protected static function boot()
    {
        parent::boot();

        // Generar automáticamente el slug al crear un negocio
        static::saving(function ($restaurants) {
            if ($restaurants->isDirty('name') || empty($restaurants->slug)) {
                $restaurants->slug = Str::slug($restaurants->name);
            }
        });
    }

    // Obtener el negocio por slug en lugar de ID
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getCnameAttribute()
    {
        $name = explode(' ', $this->name);
        return implode('', $name);  // Une todas las partes sin espacio
    }

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
        return $this->hasOneThrough(Business::class, BusinessRestaurants::class, 'restaurant_id', 'id', 'id', 'business_id');
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

    public function projections(): hasMany
    {
        return $this->hasMany(Projection::class, 'restaurant_id', 'id');
    }

    public function getColumnSumByYear(string $column, int $year, int $restaurantId = null): float
    {
        $query = Projection::where('year', $year);

        if ($restaurantId) {
            $query->where('restaurant_id', $restaurantId);
        }

        return $query->sum($column);
    }
}

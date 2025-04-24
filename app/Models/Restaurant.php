<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;
use \Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PhpParser\Builder\FunctionLike;

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

    protected $hidden = [
        'ip',
        'database',
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
    
    public function projections_days(): hasMany
    {
        return $this->hasMany(ProjectionDay::class, 'restaurant_id', 'id');
    }

    public function getColumnSumByYear(string $column, int $year, int $restaurantId = null): float
    {
        $query = Projection::where('year', $year);

        if ($restaurantId) {
            $query->where('restaurant_id', $restaurantId);
        }

        return $query->sum($column);
    }



    /**
     * 
     * DATA SCOPES START
     * 
     */


    /**
     * Scope para restaurantes asignados por empresa y usuario
     *  */ 

     public function scopeAssignedToBusinessAndUser($query, $businessId, $userId = null)
     {
         $userId = $userId ?? Auth::user()->id;
         
         return $query->whereHas('business', function($q) use ($businessId) {
                 $q->where('business.id', $businessId);
             })
             ->whereHas('users', function($q) use ($userId) {
                 $q->where('users.id', $userId);
             });
     }

    /**
     * Scope para ver restaurantes que no estan asignados
     */
    public function scopeUnassigned($query, $businessId)
    {
        return $query->where(function ($q) use ($businessId) {
            $q->doesntHave('business');
        })->orWhereHas('business', function ($q) use ($businessId) {
            $q->where('id', $businessId);
        });
    }

    /**
     * Scope para filtrar por año y mes
     */
    public function scopeForDate($query, $year, $month)
    {
        return $query->where('year', $year)->where('month', $month);
    }

    /**
     * Scope para filtrar por día específico
     */
    public function scopeForDay($query, $day)
    {
        return $query->where('day_of_month', $day);
    }

    /**
     * Scope para proyecciones activas
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * 
     * DATA SCOPES END
     * 
     */
}

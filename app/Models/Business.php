<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Business extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "business";
    protected $fillable = [
        'name', 'business_name', 'business_address', 'rfc', 'telephone', 'business_line', 'email', 'web', 'country', 'state', 'city', 'regime', 'business_file', 'idregiment_sat'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_business', 'business_id', 'user_id');
    }

   public function restaurants()
    {
        return $this->hasManyThrough(Restaurant::class,BusinessRestaurants::class,'business_id','id','id','restaurant_id');
    }
}

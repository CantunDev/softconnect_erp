<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRestaurant extends Model
{
    use HasFactory;
    protected $table = "users_restaurants";
    protected $fillable = [
        'user_id',
        'restaurant_id'
    ];
}

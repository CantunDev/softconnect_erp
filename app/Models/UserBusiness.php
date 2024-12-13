<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBusiness extends Model
{
    use HasFactory;
    protected $table = "users_business";
    protected $fillable = [
        'user_id',
        'business_id'
    ];
}

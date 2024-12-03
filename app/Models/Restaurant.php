<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}

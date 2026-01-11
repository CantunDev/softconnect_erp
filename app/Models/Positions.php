<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Positions extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "positions";
    protected $fillable = [
        'restaurant_id',
        'name',
        'description',
        'base_salary',
        'salary_type',
        'hours_per_day',
        'status'
    ];
}

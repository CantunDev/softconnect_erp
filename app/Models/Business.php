<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "business";
    protected $fillable = [
        'name', 'business_name', 'business_address', 'rfc', 'telephone', 'business_line', 'email', 'web', 'country', 'state', 'city', 'regime', 'business_file', 'idregiment_sat'
    ];
}

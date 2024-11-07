<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'business_name', 'business_address', 'rfc', 'telephone', 'business_line', 'email', 'web', 'country', 'state', 'city', 'regime', 'business_file', 'idregiment_sat'
    ];
}

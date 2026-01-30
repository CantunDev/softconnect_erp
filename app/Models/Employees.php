<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employees extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "employees";
    protected $fillable = [
        'restaurant_id',
        'position_id',
        'first_name',
        'last_name',
        'sur_name',
        'full_name',
        'email',
        'phone',
        'birth_place',
        'birth_date',
        'gender',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'hire_date',
        'termination_date',
        'employment_type',
        'status',
        'imss_number',
        'rfc',
        'curp',
        'bank_account',
        'bank_name',
        'bank_clabe',
        'notes',
        'is_active'
    ];
}

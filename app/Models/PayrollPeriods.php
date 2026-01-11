<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollPeriods extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "payroll_periods";
    protected $fillable = [
        'restaurant_id',
        'start_date',
        'end_date',
        'period_number',
        'year',
        'status',
        'notes',
        'approved_at',
        'paid_at'
    ];
}

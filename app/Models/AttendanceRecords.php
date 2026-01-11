<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceRecords extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "attendance_records";
    protected $fillable = [
        'employee_id',
        'payroll_period_id',
        'date',
        'type',
        'clock_in',
        'clock_out',
        'hours_worked',
        'notes'
    ];
}

<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChequesTemp extends Model
{
    use HasFactory;
    
    protected $connection = 'sqlsrv';
    protected $table = 'tempcheques';
    public $timestamps = false;
    protected $casts = [
        'fecha' => 'datetime',
    ];

}

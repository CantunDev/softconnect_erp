<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;     

    protected $connection = 'sqlsrv'; 
    protected $table = 'compras';
    protected $casts = [
        'fecha' => 'datetime',
    ];
    public $timestamps = false;
}

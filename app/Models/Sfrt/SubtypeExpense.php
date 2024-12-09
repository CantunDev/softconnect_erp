<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubtypeExpense extends Model
{
    use HasFactory;
    
    protected $connection = 'sqlsrv'; 
    protected $table = 'subtipogastos';
    public $timestamps = false;
    protected $casts = [
        'fecha' => 'datetime',
        'idtipogastos' => 'string',
    ];
    protected $primaryKey = 'idtipogastos';
    protected $keyType = 'string';

}

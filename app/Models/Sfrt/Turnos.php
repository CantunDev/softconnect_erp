<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Model;

class Turnos extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'turnos';
    public $timestamps = false;
    protected $casts = [
        'fecha' => 'datetime',
    ];
}

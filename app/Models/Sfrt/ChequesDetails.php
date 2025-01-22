<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Model;

class ChequesDetails extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'cheqdet';
    public $timestamps = false;
    protected $casts = [
        'hora' => 'datetime',
    ];
}

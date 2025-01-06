<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'productos';
    public $timestamps = false;
    
}

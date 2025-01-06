<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'grupos';
    public $timestamps = false;
}

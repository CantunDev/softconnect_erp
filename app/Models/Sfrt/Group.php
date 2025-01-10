<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'grupos';
    public $timestamps = false;
    protected $primaryKey = 'idgrupo';
    protected $keyType = 'string';


    public function products(): HasMany
    {
        return $this->hasMany(Products::class, 'idgrupo', 'idgrupo');
    }

    // public function products_cheques()
    // {
    //     return $this->hasManyThrough(
    //         ChequesDetails::class,
    //         Products::class,
    //         'idgrupo',
    //         'idproducto',
    //         'idgrupo',
    //         'idproducto'
    //     );
    // }
}

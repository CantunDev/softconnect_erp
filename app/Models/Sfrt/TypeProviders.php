<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeProviders extends Model
{
    use HasFactory;

     protected $connection = 'sqlsrv'; 
    protected $table = 'tipoproveedores';
    protected $fillable = [
        'idtipoproveedor',
        'descripcion'
    ];
    
    // protected $casts = [
    //     'fecha' => 'datetime',
    // ];
    // protected $appends = ['NotaProcesado'];
    public $timestamps = false;
}

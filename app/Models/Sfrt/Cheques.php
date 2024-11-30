<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cheques extends Model
{
    use HasFactory;
    
    protected $connection = 'sqlsrv'; 
    protected $table = 'cheques';
    public $timestamps = false;

     /**
     * Establece dinámicamente la conexión de base de datos.
     *
     * @param string $connectionName
     */
    public static function setDynamicConnection($connectionName)
    {
        (new static())->setConnection($connectionName);
    }

}

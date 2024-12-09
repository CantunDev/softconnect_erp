<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingAccount extends Model
{
    use HasFactory;
    
    protected $connection = 'sqlsrv'; 
    protected $table = 'cuentascontables';
    public $timestamps = false;
    public $incrementing = false; 
    protected $casts = [
        'fecha' => 'datetime',
        'idcuentacontable' => 'string',
        'usarenoperacion' => 'integer', 
    ];
    protected $primaryKey = 'idcuentacontable';
    protected $keyType = 'string'; 
    protected $guarded =
    [
        'usarenoperacion'
    ];
    
    public function getIdcuentacontableAttribute($value)
    {
        return str_pad($value, 2, '0', STR_PAD_LEFT);
    }
    
    public static function setDynamicConnection($connectionName)
    {
        (new static())->setConnection($connectionName);
    }
}

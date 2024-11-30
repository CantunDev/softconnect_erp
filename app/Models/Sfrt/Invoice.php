<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;
    
    protected $connection = 'sqlsrv'; 
    protected $table = 'facturas';
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

    /**
     * Get the user that owns the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'idcliente', 'idcliente');
    }
}

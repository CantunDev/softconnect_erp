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
    protected $casts = [
        'fecha' => 'datetime',
    ];
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


    public function getNotaProcesadoAttribute()
    {
        $nota = $this->nota ?? '';
        $notaProcesado = str_replace('Folios: P', '', $nota);
        return trim($notaProcesado); 
    }

    /**
     * Get the customers that owns the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'idcliente', 'idcliente');
    }

    /**
     * Get the cheques that owns the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cheques(): BelongsTo
    {
        return $this->belongsTo(Cheques::class, 'notaProcesado', 'numcheque');
                    // ->where('numcheque', 'LIKE', '%$valor%');
    }

    public function scopeSinCancelados($query)
    {
        return $query->whereNull('usuariocancelo');
    }

}

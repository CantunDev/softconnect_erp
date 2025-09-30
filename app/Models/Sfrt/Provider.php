<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Sfrt\Purchase;
use Illuminate\Notifications\Notifiable;

class Provider extends Model
{
    use HasFactory, Notifiable;

    const ESTADO_ACTIVO = 1;
    const ESTADO_BAJA = 2;
    // const ESTADO_SUSPENDIDO = 3; // Ejemplo adicion

    protected $connection = 'sqlsrv';
    protected $table = 'proveedores';
    protected $primaryKey = 'idproveedor';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'idproveedor',
        'nombre',
        'razonsocial',
        'direccion',
        'codigopostal',
        'telefono',
        'fax',
        'email',
        'rfc',
        'credito',
        'usarcostosasignados',
        'usarenpoliza',
        'idtipoproveedor',
        'idcuentacontable',
        'nombrebanco',
        'nocuenta',
        'cuentaclave',
        'estatus'
    ];

    // protected $appends = ['NotaProcesado'];
    public $timestamps = false;

    // public function scopeActivo($query)
    // {
    //     return $query->where('estatus', self::ESTADO_ACTIVO);
    // }

    // public function scopeBaja($query)
    // {
    //     return $query->where('estatus', self::ESTADO_BAJA);
    // }
    
    public function estaActivo()
    {
        return $this->estatus == 1; // Compara directamente con el valor
    }

    public function scopeOrderByName($query, $direction = 'asc')
    {
        return $query->orderBy('nombre', $direction);
    }

    public function getRouteKeyName()
    {
        return 'idproveedor';
    }
    /**
     * Get all of the purchases for the Purchase
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class, 'idproveedor', 'idproveedor');
    }
}

<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Sfrt\Purchase;

class Provider extends Model
{
    use HasFactory;
     
    protected $connection = 'sqlsrv'; 
    protected $table = 'proveedores';
    protected $casts = [
        'fecha' => 'datetime',
    ];
    // protected $appends = ['NotaProcesado'];
    public $timestamps = false;

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

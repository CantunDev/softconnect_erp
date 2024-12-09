<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class TypeExpense extends Model
{
    use HasFactory;
    
    protected $connection = 'sqlsrv'; 
    protected $table = 'tipogastos';
    protected $keyType = 'string';
    public $timestamps = false;
    // public $incrementing = false; // Indica que no es autoincremental
    protected $casts = [
        'fecha' => 'datetime',
        'Idtipogastos' => 'string',
    ];
    protected $fillable =
    [
        'descripcion'
    ];
    protected $primaryKey = 'Idtipogasto';
    /**
     * Get all of the comments for the TypeExpense
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

     public static function generarNuevoId()
    {   $ip = '192.168.193.226\NATIONALSOFT';
        $database = 'softrestaurant10';
        Config::set('database.connections.sqlsrv.host', $ip);
        Config::set('database.connections.sqlsrv.database', $database);
        DB::purge('sqlsrv');
    
        // Bloquea la tabla durante la generación del nuevo ID
        DB::beginTransaction();
    
        try {
            // Obtén el último ID, asegurándote de que esté en orden correcto
            $ultimoId =TypeExpense::query()
                ->lockForUpdate() // Bloquea la fila para evitar conflictos concurrentes
                ->select('Idtipogasto')
                ->orderBy('Idtipogasto', 'desc')
                ->value('Idtipogasto');
    
            // Si no hay registros, empieza en "01"
            $nuevoId = !$ultimoId
                ? '01'
                : str_pad((int)$ultimoId + 1, 2, '0', STR_PAD_LEFT);
    
            DB::commit(); // Confirma la transacción
    
            return $nuevoId;
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte en caso de error
            throw $e;
        }
    }

    public static function crearConNuevoId(array $atributos)
    {
        $ip = '192.168.193.226\NATIONALSOFT';
        $database = 'softrestaurant10';
        Config::set('database.connections.sqlsrv.host', $ip);
        Config::set('database.connections.sqlsrv.database', $database);
        DB::purge('sqlsrv');

        // Generar el nuevo ID
        $atributos['Idtipogasto'] = self::generarNuevoId();

        if (isset($atributos['descripcion'])) {
            $atributos['descripcion'] = strtoupper($atributos['descripcion']);
        }
        // Crear y retornar el modelo
        return TypeExpense::query()->insert($atributos);

    }

    public function subtype(): HasMany
    {
        return $this->hasMany(SubtypeExpense::class, 'idtipogasto');
    }
}

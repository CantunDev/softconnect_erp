<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class SubtypeExpense extends Model
{
    use HasFactory;
    
    protected $connection = 'sqlsrv'; 
    protected $table = 'subtipogastos';
    public $timestamps = false;
    protected $casts = [
        'fecha' => 'datetime',
        'idsubtipogastos' => 'string',
        'idtipogasto' => 'string',
        'idproveedor' => 'string',
        'descripcion' => 'string'
    ];
    protected $primaryKey = 'idsubtipogastos';
    protected $keyType = 'string';

    public static function generarNuevoId()
    {
        $ip = '192.168.193.226\NATIONALSOFT';
        $database = 'softrestaurant10';
        Config::set('database.connections.sqlsrv.host', $ip);
        Config::set('database.connections.sqlsrv.database', $database);
        DB::purge('sqlsrv');

        // Bloquea la tabla durante la generación del nuevo ID
        DB::beginTransaction();

        try {
            // Obtén el último ID, asegurándote de que esté en orden correcto
            $ultimoId = SubtypeExpense::query()
                ->lockForUpdate() // Bloquea la fila para evitar conflictos concurrentes
                ->select('idsubtipogastos')
                ->orderBy('idsubtipogastos', 'desc')
                ->value('idsubtipogastos');

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
        $atributos['idsubtipogastos'] = self::generarNuevoId();

        if (isset($atributos['descripcion'])) {
            $atributos['descripcion'] = strtoupper($atributos['descripcion']);
        }        
        $atributos['idtipogasto'] = $atributos['idtipogasto'];
        $atributos['idproveedor'] = $atributos['idproveedor'] ?? null;
        
        // Crear y retornar el modelo
        return SubtypeExpense::query()->insert($atributos);
    }

}

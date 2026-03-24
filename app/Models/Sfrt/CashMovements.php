<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Model;

class CashMovements extends Model
{
    
    protected $connection = 'sqlsrv';
    protected $table = 'movtoscaja';
    public $timestamps = false;
    protected $casts = [
        'fecha' => 'datetime',
    ];

    const TIPOS_MOVIMIENTO = [
        1 => ['label' => 'PROPINAS',           'badge' => 'info'],
        2 => ['label' => 'COMISIONES',          'badge' => 'warning'],
        3 => ['label' => 'COMPRAS EN EFECTIVO', 'badge' => 'success'],
        4 => ['label' => 'SALVAGUARDAS',        'badge' => 'info'],
    ];

    protected $appends = ['tipo_movto_label', 'tipo_movto_badge'];

    public function getTipoMovtoLabelAttribute(): string
    {
        return self::TIPOS_MOVIMIENTO[(int) $this->IdCashMovementType]['label'] ?? 'DESCONOCIDO';
    }

    public function getTipoMovtoBadgeAttribute(): string
    {
        return self::TIPOS_MOVIMIENTO[(int) $this->IdCashMovementType]['badge'] ?? 'secondary';
    }

}

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
    protected $appends = ['NotaProcesado'];

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
        // $nota = $this->nota ?? '';
        // $serie = Cheques::first()->seriefolio ?? '';
        // if ($serie) {
        //     // $notaProcesado = str_replace('Folios: ' . $serie, '', $nota);
        // } else {
        //     $notaProcesado = str_replace('Folios: ', '', $nota);
        // }
        // return trim($notaProcesado);

        $nota = $this->nota ?? '';
        $serie = Cheques::first()->seriefolio ?? '';
        
        if ($serie) {
            // Usar expresión regular para eliminar "Folios: {serie}" y "Factura parcial del ..."
            $notaProcesado = preg_replace(
                ["/Folios: $serie(,.*)?/", "/ Factura parcial del .*$/"], 
                '', 
                $nota
            );
        } else {
            $notaProcesado = str_replace('Folios: (.*)$/', '', $nota);
            $notaProcesado = str_replace('Factura parcial del (.*)$/', '', $notaProcesado);
        }       
        // Eliminar cualquier texto residual que no sea números y comas
        $notaProcesado = preg_replace("/[^0-9,]/", '', $notaProcesado);
        
        // Procesar múltiples números separados por comas
        $notaProcesado = collect(explode(',', $notaProcesado))
            ->map(fn($item) => trim($item)) // Limpiar espacios
            ->filter(fn($item) => is_numeric($item)) // Asegurar que sean solo números válidos
            ->implode(','); // Reconstruir como texto separado por comas
        
        // Retornar el texto limpio y procesado
        return trim($notaProcesado);
        

    }

    public function scopeSinCancelados($query)
    {
        $serie = $this->serie ?? '';  
        return $query->where('nombre_emisor', '!=', '')
                ->where(function($query) use ($serie) {
                    $nota = Cheques::first()->seriefolio ?? '';
                        if ($nota === $serie) {
                            $query->where(function ($query) use ($serie) {
                                $query->where('nota', 'like', 'Folios: ' . $serie . '%') // Caso general
                                ->orWhereRaw("nota LIKE CONCAT('Folios: ', ?, ',%')", [$serie])
                                ->orWhereRaw("nota LIKE CONCAT('Folios: ', ?, ' Factura parcial%')", [$serie]);
                            });                           
                        } elseif (!is_null($nota)) {
                            $query->where('nota', 'like', 'Folios: ' . $nota . '%')
                              // Nuevas condiciones
                              ->orWhereRaw("nota LIKE CONCAT('Folios: ', ?, ',%')", [$nota])
                              ->orWhereRaw("nota LIKE CONCAT('Folios: ', ?, ' Factura parcial%')", [$nota]);
                        }else{
                            $query->where('nota', 'not like', 'Folios: %')
                            ->orWhereRaw("nota LIKE 'Folios: % Factura parcial%'")
                            ->orWhereRaw("nota LIKE 'Folios: %, Factura parcial%'");

                        }
                });
    }


    public function getFormaDePagoTextoAttribute()
    {
        $formasDePago = [
            '01' => 'Efectivo',
            '02' => 'Cheque nominativo',
            '03' => 'Transferencia electrónica de fondos',
            '04' => 'Tarjeta de crédito',
            '05' => 'Monedero electrónico',
            '06' => 'Dinero electrónico',
            '08' => 'Vales de despensa',
            '12' => 'Dación en pago',
            '13' => 'Pago por subrogación',
            '14' => 'Pago por consignación',
            '15' => 'Condonación',
            '17' => 'Compensación',
            '23' => 'Novación',
            '24' => 'Confusión',
            '25' => 'Remisión de deuda',
            '26' => 'Prescripción o caducidad',
            '27' => 'A satisfacción del acreedor',
            '28' => 'Tarjeta de débito',
            '29' => 'Tarjeta de servicios',
            '30' => 'Aplicación de anticipos',
            '99' => 'Por definir'
        ];
        return $formasDePago[$this->formapago] ?? 'Código no válido';

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
        return $this->belongsTo(Cheques::class, 'NotaProcesado', 'numcheque');

    }
}

<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Services\DynamicConnectionService;
use Carbon\Carbon;

class SalesTotalDayComponent extends Component
{
    public $restaurants;
    public $errors = [];
    public $totals = [];
    public $colSize;

    /**
     * Create a new component instance.
     */
    public function __construct($restaurants, DynamicConnectionService $connectionService)
    {
        $this->restaurants = $restaurants;
        $this->colSize = 12; // Siempre ocupará todo el ancho

        // Inicializar totales
        $this->totals = [
            'total' => 0,
            'nopersonas' => 0,
            'chequePromedio' => 0,
            'totalTemp' => 0,
            'nopersonasTemp' => 0,
            'noclientesTemp' => 0,
            'totalclientesTemp' => 0,
            'descuentosTemp' => 0,
            'totalPaidTemp' => 0,
            'alimentosTemp' => 0,
            'bebidasTemp' => 0,
            'chequePromedioTemp' => 0,
        ];

        foreach ($this->restaurants as $i => $restaurant) {
            $connectionResult = $connectionService->configureConnection($restaurant);

            if ($connectionResult['success']) {
                $connection = $connectionResult['connection'];
                $currentMonth = now()->month;
                $currentYear = now()->year;

                // Obtener datos de la base de datos
                $chequeData = $this->getChequeData($connection, $currentMonth, $currentYear);

                // Obtener el último turno
                $lastTurno = $this->getLastTurno($connection, 'cheques');
                $lastTurnoTemp = $this->getLastTurno($connection, 'tempcheques');

                $tabla = null;
                $dateCheque = null;

                // Decidir cuál turno usar (igual que en el componente original)
                if ($lastTurno && $lastTurnoTemp) {
                    if (Carbon::parse($lastTurno->fecha)->gt(Carbon::parse($lastTurnoTemp->fecha))) {
                        $tabla = 'cheques';
                        $dateCheque = Carbon::parse($lastTurno->fecha)->toDateTimeString();
                    } else {
                        $tabla = 'tempcheques';
                        $dateCheque = Carbon::parse($lastTurnoTemp->fecha)->toDateTimeString();
                    }
                } elseif ($lastTurno) {
                    $tabla = 'cheques';
                    $dateCheque = Carbon::parse($lastTurno->fecha)->toDateTimeString();
                } elseif ($lastTurnoTemp) {
                    $tabla = 'tempcheques';
                    $dateCheque = Carbon::parse($lastTurnoTemp->fecha)->toDateTimeString();
                } else {
                    $tabla = 'tempcheques';
                    $dateCheque = now()->toDateString();
                }

                // Obtener datos temporales
                $tempChequeData = $this->getTempChequeData($connection, $tabla, $currentMonth, $currentYear, $dateCheque);

                // Sumar los valores al total general
                $this->totals['total'] += $chequeData['total'];
                $this->totals['nopersonas'] += $chequeData['nopersonas'];
                
                $this->totals['totalTemp'] += $tempChequeData['totalTemp'];
                $this->totals['nopersonasTemp'] += $tempChequeData['nopersonasTemp'];
                $this->totals['noclientesTemp'] += $tempChequeData['noclientesTemp'];
                $this->totals['totalclientesTemp'] += $tempChequeData['totalclientesTemp'];
                $this->totals['descuentosTemp'] += $tempChequeData['descuentosTemp'];
                $this->totals['totalPaidTemp'] += $tempChequeData['totalPaidTemp'];
                $this->totals['alimentosTemp'] += $tempChequeData['alimentosTemp'];
                $this->totals['bebidasTemp'] += $tempChequeData['bebidasTemp'];

            } else {
                // Almacenar el mensaje de error
                $this->errors[] = "Error en {$restaurant->name}: " . $connectionResult['message'];
            }
        }

        // Calcular promedios generales
        $this->totals['chequePromedio'] = $this->totals['nopersonas'] > 0 
            ? round(($this->totals['total'] / $this->totals['nopersonas']), 2) 
            : 0;

        $this->totals['chequePromedioTemp'] = $this->totals['totalclientesTemp'] > 0 
            ? round(($this->totals['totalTemp'] / $this->totals['totalclientesTemp']), 2) 
            : 0;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sales-total-day-component', [
            'errors' => $this->errors,
            'totals' => $this->totals,
        ]);
    }

    /**
     * Obtiene los datos de los cheques.
     */
    private function getChequeData($connection, $currentMonth, $currentYear)
    {
        $total = $connection->table('cheques')
            ->whereMonth('fecha', $currentMonth)
            ->whereYear('fecha', $currentYear)
            ->where('pagado', true)
            ->where('cancelado', false)
            ->sum('total');

        $nopersonas = $connection->table('cheques')
            ->whereMonth('fecha', $currentMonth)
            ->whereYear('fecha', $currentYear)
            ->where('pagado', true)
            ->where('cancelado', false)
            ->sum('nopersonas');

        return [
            'total' => $total,
            'nopersonas' => $nopersonas,
        ];
    }

    /**
     * Obtiene el último turno de la tabla especificada.
     */
    private function getLastTurno($connection, $table)
    {
        return $connection->table($table)
            ->select('idturno', 'fecha')
            ->orderBy('fecha', 'desc')
            ->first();
    }

    /**
     * Obtiene los datos temporales de los cheques.
     */
    private function getTempChequeData($connection, $tabla, $currentMonth, $currentYear, $dateCheque)
    {
        $totalTemp = $connection->table($tabla)
            ->whereMonth('fecha', $currentMonth)
            ->whereYear('fecha', $currentYear)
            ->whereDate('fecha', $dateCheque)
            ->where('cancelado', false)
            ->sum('total');

        $totalPaidTemp = $connection->table($tabla)
            ->whereMonth('fecha', $currentMonth)
            ->whereYear('fecha', $currentYear)
            ->whereDate('fecha', $dateCheque)
            ->where('pagado', true)
            ->where('cancelado', false)
            ->sum('total');

        $nopersonasTemp = $connection->table($tabla)
            ->whereMonth('fecha', $currentMonth)
            ->whereYear('fecha', $currentYear)
            ->whereDate('fecha', $dateCheque)
            ->where('pagado', false)
            ->where('cancelado', false)
            ->sum('nopersonas');

        $noclientesTemp = $connection->table($tabla)
            ->whereMonth('fecha', $currentMonth)
            ->whereYear('fecha', $currentYear)
            ->whereDate('fecha', $dateCheque)
            ->where('pagado', true)
            ->where('cancelado', false)
            ->sum('nopersonas');

        $totalclientesTemp = $connection->table($tabla)
            ->whereMonth('fecha', $currentMonth)
            ->whereYear('fecha', $currentYear)
            ->whereDate('fecha', $dateCheque)
            ->where('cancelado', false)
            ->sum('nopersonas');

        $descuentosTemp = $connection->table($tabla)
            ->whereMonth('fecha', $currentMonth)
            ->whereYear('fecha', $currentYear)
            ->whereDate('fecha', $dateCheque)
            ->where('cancelado', false)
            ->sum('descuentoimporte');

        $alimentosTemp = $connection->table($tabla)
            ->whereMonth('fecha', $currentMonth)
            ->whereYear('fecha', $currentYear)
            ->whereDate('fecha', $dateCheque)
            ->where('cancelado', false)
            ->sum('totalalimentos');

        $bebidasTemp = $connection->table($tabla)
            ->whereMonth('fecha', $currentMonth)
            ->whereYear('fecha', $currentYear)
            ->whereDate('fecha', $dateCheque)
            ->where('cancelado', false)
            ->sum('totalbebidas');

        return [
            'totalTemp' => $totalTemp,
            'nopersonasTemp' => $nopersonasTemp,
            'noclientesTemp' => $noclientesTemp,
            'totalclientesTemp' => $totalclientesTemp,
            'descuentosTemp' => $descuentosTemp,
            'totalPaidTemp' => $totalPaidTemp,
            'alimentosTemp' => $alimentosTemp,
            'bebidasTemp' => $bebidasTemp,
        ];
    }
}
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
    public $currentDate;

    /**
     * Create a new component instance.
     */
    public function __construct($restaurants, DynamicConnectionService $connectionService)
    {
        $this->restaurants = $restaurants;
        $this->colSize = 12;
        $this->currentDate = now()->toDateString();

        // Inicializar totales
        $this->initializeTotals();

        foreach ($this->restaurants as $restaurant) {
            $this->processRestaurantData($restaurant, $connectionService);
        }

        $this->calculateAverages();
    }

    private function initializeTotals()
    {
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
            'turnoStatus' => 'Sin datos',
            'fechaTurno' => $this->currentDate,
            'restaurantesIncluidos' => 0
        ];
    }

    private function processRestaurantData($restaurant, $connectionService)
    {
        $connectionResult = $connectionService->configureConnection($restaurant);

        if ($connectionResult['success']) {
            $connection = $connectionResult['connection'];
            $currentMonth = now()->month;
            $currentYear = now()->year;

            // Obtener los últimos turnos
            $lastTurno = $this->getLastTurno($connection, 'cheques');
            $lastTurnoTemp = $this->getLastTurno($connection, 'tempcheques');

            // Determinar qué turno usar
            $turnoData = $this->determineTurnoToUse($lastTurno, $lastTurnoTemp);
            
            // Solo procesar si es del día actual
            if ($this->isSameDay($turnoData['fecha'])) {
                $this->processValidTurno($connection, $restaurant, $turnoData, $currentMonth, $currentYear);
            }
        } else {
            $this->errors[] = "Error en {$restaurant->name}: " . $connectionResult['message'];
        }
    }

    private function determineTurnoToUse($lastTurno, $lastTurnoTemp)
    {
        // Si ambos turnos existen
        if ($lastTurno && $lastTurnoTemp) {
            $fechaTurno = Carbon::parse($lastTurno->fecha);
            $fechaTurnoTemp = Carbon::parse($lastTurnoTemp->fecha);

            // Preferir el turno cerrado si es más reciente o del mismo día
            if ($fechaTurno->gt($fechaTurnoTemp) || $fechaTurno->isSameDay($fechaTurnoTemp)) {
                return [
                    'tabla' => 'cheques',
                    'status' => 'Cerrado',
                    'fecha' => $lastTurno->fecha
                ];
            } else {
                return [
                    'tabla' => 'tempcheques',
                    'status' => 'Abierto',
                    'fecha' => $lastTurnoTemp->fecha
                ];
            }
        } elseif ($lastTurno) {
            return [
                'tabla' => 'cheques',
                'status' => 'Cerrado',
                'fecha' => $lastTurno->fecha
            ];
        } elseif ($lastTurnoTemp) {
            return [
                'tabla' => 'tempcheques',
                'status' => 'Abierto',
                'fecha' => $lastTurnoTemp->fecha
            ];
        }

        // Default (no debería ocurrir si hay datos)
        return [
            'tabla' => 'tempcheques',
            'status' => 'Abierto',
            'fecha' => now()
        ];
    }

    private function isSameDay($fechaTurno)
    {
        return Carbon::parse($fechaTurno)->isSameDay($this->currentDate);
    }

    private function processValidTurno($connection, $restaurant, $turnoData, $currentMonth, $currentYear)
    {
        // Obtener datos del turno
        $chequeData = $this->getChequeData($connection, $currentMonth, $currentYear);
        $tempChequeData = $this->getTempChequeData(
            $connection, 
            $turnoData['tabla'], 
            $currentMonth, 
            $currentYear, 
            $turnoData['fecha']
        );

        // Actualizar estado general del turno
        if ($this->totals['restaurantesIncluidos'] == 0) {
            $this->totals['turnoStatus'] = $turnoData['status'];
            $this->totals['fechaTurno'] = Carbon::parse($turnoData['fecha'])->toDateString();
        } else {
            // Si hay mezcla de estados, marcamos como "Mixto"
            if ($this->totals['turnoStatus'] != $turnoData['status']) {
                $this->totals['turnoStatus'] = 'Mixto';
            }
        }

        // Sumar los valores al total general
        $this->sumToTotals($chequeData, $tempChequeData);
        $this->totals['restaurantesIncluidos']++;
    }

    private function sumToTotals($chequeData, $tempChequeData)
    {
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
    }

    private function calculateAverages()
    {
        $this->totals['chequePromedio'] = $this->totals['nopersonas'] > 0 
            ? round(($this->totals['total'] / $this->totals['nopersonas']), 2) 
            : 0;

        $this->totals['chequePromedioTemp'] = $this->totals['totalclientesTemp'] > 0 
            ? round(($this->totals['totalTemp'] / $this->totals['totalclientesTemp']), 2) 
            : 0;
    }

    public function render(): View|Closure|string
    {
        return view('components.sales-total-day-component', [
            'errors' => $this->errors,
            'totals' => $this->totals,
        ]);
    }

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

    private function getLastTurno($connection, $table)
    {
        return $connection->table($table)
            ->select('idturno', 'fecha')
            ->orderBy('fecha', 'desc')
            ->first();
    }

    private function getTempChequeData($connection, $table, $currentMonth, $currentYear, $dateCheque)
    {
        $date = Carbon::parse($dateCheque);

        $query = $connection->table($table)
            ->whereMonth('fecha', $currentMonth)
            ->whereYear('fecha', $currentYear)
            ->whereDate('fecha', $date->toDateString())
            ->where('cancelado', false);

        return [
            'totalTemp' => $query->sum('total'),
            'totalPaidTemp' => $query->clone()->where('pagado', true)->sum('total'),
            'nopersonasTemp' => $query->clone()->where('pagado', false)->sum('nopersonas'),
            'noclientesTemp' => $query->clone()->where('pagado', true)->sum('nopersonas'),
            'totalclientesTemp' => $query->clone()->sum('nopersonas'),
            'descuentosTemp' => $query->clone()->sum('descuentoimporte'),
            'alimentosTemp' => $query->clone()->sum('totalalimentos'),
            'bebidasTemp' => $query->clone()->sum('totalbebidas'),
        ];
    }
}
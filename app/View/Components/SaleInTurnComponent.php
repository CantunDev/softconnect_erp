<?php

namespace App\View\Components;

use App\Helpers\DateHelper;
use App\Models\ProjectionDay;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Services\DynamicConnectionService;
use Carbon\Carbon;
use Illuminate\Container\Attributes\DB;

class SaleInTurnComponent extends Component
{
    public $restaurants;
    public $errors = [];
    public $results = [];
    public $projectionDaily = [];
    public $colSize;

    /**
     * Create a new component instance.
     */
    public function __construct($restaurants, DynamicConnectionService $connectionService, DateHelper $date)
    {
        $this->restaurants = $restaurants;
        $this->colSize = $this->calculateColSize(count($restaurants));

        foreach ($this->restaurants as $i => $restaurant) {
            $currentDay = $date->getCurrentDate(); //Dia actual
            // $this->projectionDaily['daily'.$restaurant->id] = $this->getRestaurantProjectionDaily($restaurant, $currentDay);

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

                $turno = [];
                $tabla = null;
                $dateCheque = null;

                // Decidir cuál turno usar
                if ($lastTurno && $lastTurnoTemp) {
                    if (Carbon::parse($lastTurno->fecha)->gt(Carbon::parse($lastTurnoTemp->fecha))) {
                        $tabla = 'cheques';
                        $turno = 'Cerrado';
                        $dateCheque = Carbon::parse($lastTurno->fecha)->toDateTimeString();
                    } else {
                        $tabla = 'tempcheques';
                        $turno = 'Abierto';
                        $dateCheque = Carbon::parse($lastTurnoTemp->fecha)->toDateTimeString();
                    }
                } elseif ($lastTurno) {
                    $tabla = 'cheques';
                    $turno = 'Cerrado';
                    $dateCheque = Carbon::parse($lastTurno->fecha)->toDateTimeString();
                } elseif ($lastTurnoTemp) {
                    $tabla = 'tempcheques';
                    $turno = 'Abierto';
                    $dateCheque = Carbon::parse($lastTurnoTemp->fecha)->toDateTimeString();
                } else {
                    $tabla = 'tempcheques';
                    $turno = 'Abierto';
                    $dateCheque = now()->toDateString(); // Fecha por defecto
                }

                // Obtener datos temporales
                $tempChequeData = $this->getTempChequeData($connection, $tabla, $currentMonth, $currentYear, $dateCheque);
                $this->projectionDaily['daily' . $restaurant->id] = $this->getRestaurantProjectionDaily($restaurant, $dateCheque);

                // Almacenar los resultados con la clave dinámica
                $this->results['venta' . $restaurant->id] = [
                    'name' => $restaurant->name,
                    'total' => $chequeData['total'],
                    'nopersonas' => $chequeData['nopersonas'],
                    'chequePromedio' => $chequeData['chequePromedio'],
                    'lastTurno' => $lastTurno,
                    'tempChequeData' => $tempChequeData,
                    'turno' => $turno,
                ];
            } else {
                // Almacenar el mensaje de error
                $this->errors[] = "Error en {$restaurant->name}: " . $connectionResult['message'];
            }
        }
    }

    /**
     * Calcula el tamaño de columna basado en el número de restaurantes.
     */
    private function calculateColSize($count)
    {
        return match (true) {
            $count === 1 => 12,
            $count === 2 => 6,
            default => 4,
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sale-in-turn-component', [
            'errors' => $this->errors,
            'results' => $this->results,
        ]);
    }

    /**
     * Obtencion de las metas diarias
     */
    private function getRestaurantProjectionDaily($restaurant, $dateCheque)
    {
        $dateCheque = Carbon::parse($dateCheque)->toDateString();

        $projection = ProjectionDay::where('restaurant_id', $restaurant->id)
            ->where('date', $dateCheque)
            ->first();
        dd($restaurant->id, $dateCheque, $projection); // 👈 pon esto

        if (!$projection) {
            return [
                'dailySales' => [
                    'projected_day_sales' => 0,
                    'actual_day_sales' => 0,
                    'difference' => 0,
                ]
            ];
        }

        return [
            'dailySales' => [
                'projected_day_sales' => (float) $projection->projected_day_sales, // Convertimos a número
                'actual_day_sales' => (float) ($projection->actual_day_sales ?? 0),
                'difference' => (float) ($projection->actual_day_sales ?? 0) - (float) ($projection->projected_day_sales ?? 0),
            ]
        ];
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

        $chequePromedio = $nopersonas > 0 ? round(($total / $nopersonas), 2) : 0;

        return [
            'total' => $total,
            'nopersonas' => $nopersonas,
            'chequePromedio' => $chequePromedio,
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

        $chequePromedioTemp = $totalclientesTemp > 0 ? round(($totalTemp / $totalclientesTemp), 2) : 0;

        return [
            'totalTemp' => $totalTemp,
            'nopersonasTemp' => $nopersonasTemp,
            'noclientesTemp' => $noclientesTemp,
            'totalclientesTemp' => $totalclientesTemp,
            'descuentosTemp' => $descuentosTemp,
            'totalPaidTemp' => $totalPaidTemp,
            'alimentosTemp' => $alimentosTemp,
            'bebidasTemp' => $bebidasTemp,
            'chequePromedioTemp' => $chequePromedioTemp,
        ];
    }
}

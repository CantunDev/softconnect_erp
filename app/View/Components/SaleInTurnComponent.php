<?php

namespace App\View\Components;

use App\Helpers\DateHelper;
use App\Models\ProjectionDay;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Services\DynamicConnectionService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class SaleInTurnComponent extends Component
{
    public $restaurants;
    public $errors = [];
    public $results = [];
    public $projectionDaily = [];
    public $colSize;

    public function __construct($restaurants, DynamicConnectionService $connectionService, DateHelper $date)
    {
        $this->restaurants = $restaurants;
        $this->colSize = $this->calculateColSize(count($restaurants));

        foreach ($this->restaurants as $restaurant) {

            $cacheKey = "dashboard_restaurant_" . $restaurant->id;

            $data = Cache::remember($cacheKey, 60, function () use ($restaurant, $connectionService) {

                $connectionResult = $connectionService->configureConnection($restaurant);

                if (!$connectionResult['success']) {
                    return ['error' => $connectionResult['message']];
                }

                $connection = $connectionResult['connection'];
                $currentMonth = now()->month;
                $currentYear = now()->year;

                // 🔥 1. Cheques (UNA QUERY)
                $chequeData = $connection->table('cheques')
                    ->selectRaw('
                        SUM(total) as total,
                        SUM(nopersonas) as nopersonas
                    ')
                    ->whereMonth('fecha', $currentMonth)
                    ->whereYear('fecha', $currentYear)
                    ->where('pagado', true)
                    ->where('cancelado', false)
                    ->first();

                $total = $chequeData->total ?? 0;
                $nopersonas = $chequeData->nopersonas ?? 0;
                $chequePromedio = $nopersonas > 0 ? round(($total / $nopersonas), 2) : 0;

                // 🔥 2. Último turno (1 query por tabla)
                $lastTurno = $this->getLastTurno($connection, 'cheques');
                $lastTurnoTemp = $this->getLastTurno($connection, 'tempcheques');

                // 🔥 lógica intacta
                if ($lastTurno && $lastTurnoTemp) {
                    if (Carbon::parse($lastTurno->fecha)->gt(Carbon::parse($lastTurnoTemp->fecha))) {
                        $tabla = 'cheques';
                        $turno = 'Cerrado';
                        $dateCheque = $lastTurno->fecha;
                    } else {
                        $tabla = 'tempcheques';
                        $turno = 'Abierto';
                        $dateCheque = $lastTurnoTemp->fecha;
                    }
                } elseif ($lastTurno) {
                    $tabla = 'cheques';
                    $turno = 'Cerrado';
                    $dateCheque = $lastTurno->fecha;
                } elseif ($lastTurnoTemp) {
                    $tabla = 'tempcheques';
                    $turno = 'Abierto';
                    $dateCheque = $lastTurnoTemp->fecha;
                } else {
                    $tabla = 'tempcheques';
                    $turno = 'Abierto';
                    $dateCheque = now();
                }

                // 🔥 3. TEMP DATA (UNA SOLA QUERY)
                $tempData = $connection->table($tabla)
                    ->selectRaw('
                        SUM(total) as totalTemp,
                        SUM(CASE WHEN pagado = 1 THEN total ELSE 0 END) as totalPaidTemp,
                        SUM(CASE WHEN pagado = 0 THEN nopersonas ELSE 0 END) as nopersonasTemp,
                        SUM(CASE WHEN pagado = 1 THEN nopersonas ELSE 0 END) as noclientesTemp,
                        SUM(nopersonas) as totalclientesTemp,
                        SUM(descuentoimporte) as descuentosTemp,
                        SUM(totalalimentos) as alimentosTemp,
                        SUM(totalbebidas) as bebidasTemp
                    ')
                    ->whereMonth('fecha', $currentMonth)
                    ->whereYear('fecha', $currentYear)
                    ->whereDate('fecha', Carbon::parse($dateCheque)->toDateString())
                    ->where('cancelado', false)
                    ->first();

                $totalTemp = $tempData->totalTemp ?? 0;
                $totalclientesTemp = $tempData->totalclientesTemp ?? 0;

                $chequePromedioTemp = $totalclientesTemp > 0
                    ? round(($totalTemp / $totalclientesTemp), 2)
                    : 0;

                return [
                    'name' => $restaurant->name,
                    'total' => $total,
                    'nopersonas' => $nopersonas,
                    'chequePromedio' => $chequePromedio,
                    'lastTurno' => $lastTurno,
                    'turno' => $turno,
                    'dateCheque' => $dateCheque,
                    'tempChequeData' => [
                        'totalTemp' => $totalTemp,
                        'nopersonasTemp' => $tempData->nopersonasTemp ?? 0,
                        'noclientesTemp' => $tempData->noclientesTemp ?? 0,
                        'totalclientesTemp' => $totalclientesTemp,
                        'descuentosTemp' => $tempData->descuentosTemp ?? 0,
                        'totalPaidTemp' => $tempData->totalPaidTemp ?? 0,
                        'alimentosTemp' => $tempData->alimentosTemp ?? 0,
                        'bebidasTemp' => $tempData->bebidasTemp ?? 0,
                        'chequePromedioTemp' => $chequePromedioTemp,
                    ]
                ];
            });

            if (isset($data['error'])) {
                $this->errors[] = "Error en {$restaurant->name}: " . $data['error'];
                continue;
            }

            // 🔥 proyección (fuera del cache porque puede cambiar más seguido)
            $this->projectionDaily['daily' . $restaurant->id] =
                $this->getRestaurantProjectionDaily($restaurant, $data['dateCheque']);

            $this->results['venta' . $restaurant->id] = $data;
        }
    }

    private function calculateColSize($count)
    {
        return match (true) {
            $count === 1 => 12,
            $count === 2 => 6,
            default => 4,
        };
    }

    public function render(): View|Closure|string
    {
        return view('components.sale-in-turn-component', [
            'errors' => $this->errors,
            'results' => $this->results,
        ]);
    }

    private function getRestaurantProjectionDaily($restaurant, $dateCheque)
    {
        $dateCheque = Carbon::parse($dateCheque)->toDateString();

        $projection = ProjectionDay::where('restaurant_id', $restaurant->id)
            ->where('date', $dateCheque)
            ->first();

        return [
            'dailySales' => [
                'projected_day_sales' => (float) ($projection->projected_day_sales ?? 0),
                'actual_day_sales' => (float) ($projection->actual_day_sales ?? 0),
                'difference' => (float) ($projection->actual_day_sales ?? 0) - (float) ($projection->projected_day_sales ?? 0),
            ]
        ];
    }

    private function getLastTurno($connection, $table)
    {
        return $connection->table($table)
            ->select('idturno', 'fecha')
            ->orderBy('fecha', 'desc')
            ->first();
    }
}
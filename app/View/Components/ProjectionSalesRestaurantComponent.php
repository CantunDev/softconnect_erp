<?php

namespace App\View\Components;

use App\Helpers\DateHelper;
use App\Services\DynamicConnectionService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProjectionSalesRestaurantComponent extends Component
{
    public $restaurants;
    public $colSize;
    public $results = [];
    public $errors = [];

    public function __construct($restaurants, DynamicConnectionService $connectionService, DateHelper $date)
    {
        $this->restaurants = $restaurants;
        $this->colSize = $this->calculateColSize(count($restaurants));
        
        foreach ($this->restaurants as $i => $restaurant) {
            $connectionResult = $connectionService->configureConnection($restaurant);
            
            if ($connectionResult['success']) {
                $connection = $connectionResult['connection'];
                $currentMonth = $date->getCurrentMonth();
                $currentYear = $date->getCurrentYear();
                $currentDay = $date->getCurrentDay();
                $daysInMonth = $date->getDaysInMonth();
                
                // Obtener datos de ventas
                $chequeData = $this->getChequeData($connection, $currentMonth, $currentYear);
                
                // Obtener datos temporales (para ventas del día)
                $tempChequeData = $this->getTempChequeData($connection, $currentMonth, $currentYear);
                
                // Obtener proyecciones del restaurante
                $projection = $this->getRestaurantProjection($restaurant, $currentYear, $currentMonth);
                
                // Calcular todas las métricas
                $metrics = $this->calculateAllMetrics(
                    $chequeData,
                    $tempChequeData,
                    $projection,
                    $currentDay,
                    $daysInMonth
                );
                
                // Almacenar resultados
                $this->results['venta' . $restaurant->id] = [
                    'name' => $restaurant->name,
                    'data' => array_merge($chequeData, $tempChequeData),
                    'projection' => $projection,
                    'metrics' => $metrics,
                    'color_primary' => $restaurant->color_primary ?? '#ccc',
                    'color_accent' => $restaurant->color_accent ?? '#000'
                ];
            } else {
                $this->errors[] = "Error en {$restaurant->name}: " . $connectionResult['message'];
            }
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

    private function getChequeData($connection, $month, $year)
    {
        return [
            'total' => $connection->table('cheques')
                ->whereMonth('fecha', $month)
                ->whereYear('fecha', $year)
                ->where('pagado', true)
                ->where('cancelado', false)
                ->sum('total'),
                
            'nopersonas' => $connection->table('cheques')
                ->whereMonth('fecha', $month)
                ->whereYear('fecha', $year)
                ->where('pagado', true)
                ->where('cancelado', false)
                ->sum('nopersonas'),
                
            'chequePromedio' => $connection->table('cheques')
                ->whereMonth('fecha', $month)
                ->whereYear('fecha', $year)
                ->where('pagado', true)
                ->where('cancelado', false)
                ->avg('total') ?? 0
        ];
    }

    private function getTempChequeData($connection, $month, $year)
    {
        $today = now()->format('Y-m-d');
        
        return [
            'totalTemp' => $connection->table('tempcheques')
                ->whereMonth('fecha', $month)
                ->whereYear('fecha', $year)
                ->whereDate('fecha', $today)
                ->where('cancelado', false)
                ->sum('total'),
                
            'totalclientesTemp' => $connection->table('tempcheques')
                ->whereMonth('fecha', $month)
                ->whereYear('fecha', $year)
                ->whereDate('fecha', $today)
                ->where('cancelado', false)
                ->sum('nopersonas'),
                
            'chequePromedioTemp' => $connection->table('tempcheques')
                ->whereMonth('fecha', $month)
                ->whereYear('fecha', $year)
                ->whereDate('fecha', $today)
                ->where('cancelado', false)
                ->avg('total') ?? 0
        ];
    }

    private function getRestaurantProjection($restaurant, $year, $month)
    {
        if (!isset($restaurant->projections) || empty($restaurant->projections)) {
            return [
                'sales_goal' => 0,
                'clients_goal' => 0,
                'avg_check_goal' => 0
            ];
        }
        
        foreach ($restaurant->projections as $projection) {
            if ($projection->year == $year && $projection->month == $month) {
                return [
                    'sales_goal' => $projection->projected_sales,
                    'clients_goal' => $projection->projected_clients,
                    'avg_check_goal' => $projection->projected_avg_check
                ];
            }
        }
        
        return [
            'sales_goal' => 0,
            'clients_goal' => 0,
            'avg_check_goal' => 0
        ];
    }

    private function calculateAllMetrics($chequeData, $tempChequeData, $projection, $currentDay, $daysInMonth)
    {
        // Cálculos de ventas
        $dailySalesGoal = $projection['sales_goal'] / $daysInMonth;
        $salesGoalToDate = $dailySalesGoal * $currentDay;
        $salesPercentage = $salesGoalToDate > 0 ? ($tempChequeData['totalTemp'] / $salesGoalToDate) * 100 : 0;
        $salesReach = $tempChequeData['totalTemp'] - $salesGoalToDate;
        $salesDeficit = $projection['sales_goal'] - $chequeData['total'];
        $dailySalesAverage = $currentDay > 0 ? $tempChequeData['totalTemp'] / $currentDay : 0;
        $monthlySalesProjection = $dailySalesAverage * $daysInMonth;
        $salesProjectionDiff = $monthlySalesProjection - $projection['sales_goal'];

        // Cálculos de clientes
        $dailyClientsGoal = $projection['clients_goal'] / $daysInMonth;
        $clientsGoalToDate = $dailyClientsGoal * $currentDay;
        $clientsPercentage = $clientsGoalToDate > 0 ? ($tempChequeData['totalclientesTemp'] / $clientsGoalToDate) * 100 : 0;
        $clientsReach = $tempChequeData['totalclientesTemp'] - $clientsGoalToDate;

        // Cálculos de cheques promedio
        $checkDeficit = $projection['avg_check_goal'] - $tempChequeData['chequePromedioTemp'];

        return [
            'sales' => [
                'daily_goal' => round($dailySalesGoal, 2),
                'goal_to_date' => round($salesGoalToDate, 2),
                'percentage' => round($salesPercentage, 2),
                'reach' => round($salesReach, 2),
                'deficit' => round($salesDeficit, 2),
                'daily_average' => round($dailySalesAverage, 2),
                'monthly_projection' => round($monthlySalesProjection, 2),
                'projection_diff' => round($salesProjectionDiff, 2)
            ],
            'clients' => [
                'daily_goal' => round($dailyClientsGoal, 2),
                'goal_to_date' => round($clientsGoalToDate, 2),
                'percentage' => round($clientsPercentage, 2),
                'reach' => round($clientsReach, 2)
            ],
            'checks' => [
                'deficit' => round($checkDeficit, 2)
            ]
        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.projection-sales-restaurant-component', [
            'results' => $this->results,
            'errors' => $this->errors,
            'colSize' => $this->colSize
        ]);
    }
}
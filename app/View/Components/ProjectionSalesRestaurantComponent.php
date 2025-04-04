<?php

namespace App\View\Components;

use App\Helpers\DateHelper;
use App\Services\DynamicConnectionService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProjectionSalesRestaurantComponent extends Component
{
    /**
     * Create a new component instance.
     */

    public $restaurants;
    public $colSize;
    public $results = [];
    public $errors = [];
    public $projection = [];
    public $currentDay;
    public function __construct($restaurants, DynamicConnectionService $connectionService, DateHelper $date)
    {
        $this->restaurants = $restaurants;
        $this->colSize = $this->calculateColSize(count($restaurants));
        $this->currentDay = $date->getCurrentDay();
        
        foreach ($this->restaurants as $i => $restaurant) {
            $currentMonth = $date->getCurrentMonth(); //Mes actual
            $currentYear = $date->getCurrentYear(); //Año actual
            $currentDay = $date->getCurrentDay(); //Dia actual
            $daysInMonth = $date->getDaysInMonth(); //Total de dias en el mes 

            // Funcion para obtener las metas por año y mes 
            $projection = $this->getRestaurantProjection($restaurant, $currentYear, $currentMonth);

            // Funcion para obtener la conexion por restaurante 
            $connectionResult = $connectionService->configureConnection($restaurant);

            //  Almacenamiento de metas 
            $this->projection['sales' . $restaurant->id] = [
                'projected_sales' => $projection['projected_sales'],
                'projected_tax' => $projection['projected_tax'],
                'projected_check' => $projection['projected_check'],
            ];
            
            if ($connectionResult['success']) {
                $connection = $connectionResult['connection'];
                $chequeData = $this->getChequeData($connection, $currentMonth, $currentYear);
                

                // Calculos para las metas mensuales
                 $goals = $this->getGoals($projection, $chequeData,$date);

                 $this->results['venta' . $restaurant->id] = [
                    'name' => $restaurant->name,
                    'total' => $chequeData['total'],
                    'nopersonas' => $chequeData['nopersonas'],
                    'chequePromedio' => $chequeData['chequePromedio'],
                ];

                 $this->projection['goals' . $restaurant->id] = [
                    'dailySalesGoal' => $goals['dailySalesGoal'],
                    'salesGoalToDate' => $goals['salesGoalToDate'],
                    'diffProyectionGoal' => $goals['diffProyectionGoal'],
                    'goals_daily' => $goals['goals_daily'],
                    'sales_avg_daily' => $goals['sales_avg_daily'],
                    'goals_sales_projected' => $goals['goals_sales_projected'],
                    'salesDeficit' => $goals['salesDeficit'],
                    'sales_difference' => $goals['sales_difference'],
                    'goals_tax' => $goals['goals_tax'],
                    'taxGoalToDate' => $goals['taxGoalToDate'],
                    'tax_difference' => $goals['tax_difference'],
                    'check_avg_daily' => $goals['check_avg_daily'],
                    'check_defficit' => $goals['check_defficit']
                ];
            } else {
                // Almacenar el mensaje de error
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
    /*
    * Obtencion de las metas por año y mes para cada restaurante
    */
    private function getRestaurantProjection($restaurant, $currentYear, $currentMonth)
    {
        foreach ($restaurant->projections as $projection) {
            if ($projection->year == $currentYear && $projection->month == $currentMonth) {
                return [
                    'projected_sales' => $projection->projected_sales,
                    'projected_costs' => $projection->projected_costs,
                    'projected_profit' => $projection->projected_profit,
                    'projected_tax'   => $projection->projected_tax,
                    'projected_check' => $projection->projected_check
                ];
            }
        }
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
        ->sum('total') ?? 0; // Asegurar un valor por defecto

    $nopersonas = $connection->table('cheques')
        ->whereMonth('fecha', $currentMonth)
        ->whereYear('fecha', $currentYear)
        ->where('pagado', true)
        ->where('cancelado', false)
        ->sum('nopersonas') ?? 0; // Asegurar un valor por defecto

    $chequePromedio = $nopersonas > 0 ? round(($total / $nopersonas), 2) : 0;

    return [
        'total' => $total,
        'nopersonas' => $nopersonas,
        'chequePromedio' => $chequePromedio,
    ];
}

    /**
     * Calcula todas las proyecciones y métricas requeridas
     */
    private function getGoals( $projection, $chequeData, $date)
    {
      
        /**
         *  ---------- VENTAS ---------
         * META VENTA AL DIA = meta / dias del mes * dias analizados 
         * ALCANCE AL DIA = venta real al dia / meta clientes a la fecha * 100
         * DIF/PROY = Venta real al dia - meta de venta a la fecha
         * DEFICIT = alcance - 100
         * META VENTA DIARIA = meta / dias del mes
         * PROMEDIO VENTA DIARIA = vta_real / dias transcurridos
         * PROYECCION AL CIERRE = promedio venta * dias del mes
         * DIFERENCIA = proyectado - meta 
         * ----------- CLIENTES ------------ 
         * META DE CLIENTES AL DIA = meta_clientes / dias del mes * dias transcurridos 
         * ALCACNE AL DIA = venta real al dia / meta clientes a la fecha * 100
         * DIF/PROY =  meta_clientes - clientes al dia 
         * ------------ CHEQUE PROMEDIO -------------
         * CHEQUE PROMEDIO = Venta real / Clientes 
         * metacheques - promedio cheque actual
         */

         /*VENTAS*/
         $sales_total = $chequeData['total'] ?? 0;
         $tax_total = $chequeData['nopersonas'] ?? 0;
         $check_avg = $chequeData['chequePromedio'] ?? 0;

        $dailySalesGoal = ($projection['projected_sales'] / $date->getDaysInMonth())  *  $date->getDaysPassed();
        $salesGoalToDate = $projection['projected_tax'] != 0  ? ($projection['projected_sales'] / $projection['projected_tax']) * 100 : 0;
        $diffProyectionGoal =  /*$chequeData['total']*/ $sales_total != 0 ?( $sales_total - $salesGoalToDate ): 0;
        $salesDeficit = $salesGoalToDate - 100;
        $goals_daily = $projection['projected_sales'] != 0 ? ($projection['projected_sales'] / $date->getDaysInMonth()): 0; 
        $sales_avg_daily = $sales_total / $date->getDaysPassed();
        $goals_sales_projected = $sales_avg_daily * $date->getDaysInMonth();
        $sales_difference = $goals_sales_projected - $projection['projected_sales'];
         /*CLIENTES*/
         $goals_tax =  $projection['projected_tax'] != 0 ? ($projection['projected_tax'] / $date->getDaysInMonth() ) * $date->getDaysPassed() : 0;
         $taxGoalToDate = ($sales_total / $projection['projected_tax']) * 100;
         $tax_difference = $projection['projected_tax'] != 0 ? ($projection['projected_tax'] - $tax_total ): 0;
         /*TICKET PROMEDIO*/
         $check_avg_daily = $sales_total / $tax_total;
         $check_defficit = $projection['projected_check'] - $check_avg;
        // $salesPercentage = $salesGoalToDate > 0 ? ($tempChequeData['totalTemp'] / $salesGoalToDate) * 100 : 0;
        // $salesReach = $tempChequeData['totalTemp'] - $salesGoalToDate;
        // $salesDeficit = $salesGoal - $chequeData['total'];
        // $dailySalesAverage = $currentDay > 0 ? $tempChequeData['totalTemp'] / $currentDay : 0;
        // $monthlySalesProjection = $dailySalesAverage * $daysInMonth;
        // $salesProjectionDiff = $monthlySalesProjection - $salesGoal;

        // $dailyClientsGoal = $clientsGoal / $daysInMonth;
        // $clientsGoalToDate = $dailyClientsGoal * $currentDay;
        // $clientsPercentage = $clientsGoalToDate > 0 ? ($tempChequeData['totalclientesTemp'] / $clientsGoalToDate) * 100 : 0;
        // $clientsReach = $tempChequeData['totalclientesTemp'] - $clientsGoalToDate;

        // $checkDeficit = $avgCheckGoal - $tempChequeData['chequePromedioTemp'];
        return [
            'dailySalesGoal' => round($dailySalesGoal, 2),
            'salesGoalToDate' => round($salesGoalToDate, 2),
            'diffProyectionGoal' => round($diffProyectionGoal, 2),
            'salesDeficit' => round($salesDeficit,2),
            'goals_daily' => round($goals_daily,2),
            'sales_avg_daily' => round($sales_avg_daily,2),
            'goals_sales_projected' => round($goals_sales_projected,2),
            'sales_difference' => round($sales_difference,2),
            'goals_tax' => round($goals_tax,2),
            'taxGoalToDate' => ceil(round($taxGoalToDate,2)),
            'tax_difference' => round($tax_difference,2),
            'check_avg_daily' => round($check_avg_daily,2),
            'check_defficit' => round($check_defficit)
    ];

        // return [
        //     'sales' => [
        //         'daily_goal' => round($dailySalesGoal, 2),
        //         'goal_to_date' => round($salesGoalToDate, 2),
        //         'percentage' => round($salesPercentage, 2),
        //         'reach' => round($salesReach, 2),
        //         'deficit' => round($salesDeficit, 2),
        //         'daily_average' => round($dailySalesAverage, 2),
        //         'monthly_projection' => round($monthlySalesProjection, 2),
        //         'projection_diff' => round($salesProjectionDiff, 2)
        //     ],
        //     'clients' => [
        //         'daily_goal' => round($dailyClientsGoal, 2),
        //         'goal_to_date' => round($clientsGoalToDate, 2),
        //         'percentage' => round($clientsPercentage, 2),
        //         'reach' => round($clientsReach, 2)
        //     ],
        //     'checks' => [
        //         'deficit' => round($checkDeficit, 2)
        //     ]
        // ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.projection-sales-restaurant-component');
    }
}

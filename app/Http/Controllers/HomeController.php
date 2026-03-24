<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Projection;
use App\Models\Restaurant;
use App\Models\Sfrt\Cheques;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\DateHelper;

class HomeController extends Controller
{
      public function index(?Business $business = null, ?Restaurant $restaurants = null, Request $request)
    {
        return view('sales.index', compact('business','restaurants'));
    }


    private function getDateDefaults(): array
    {
        $daysInMonth = DateHelper::getDaysInMonth();
        $daysPass = DateHelper::getDaysPassed();

        return [
            'day' => DateHelper::getCurrentDay(),
            'startOfMonth' => DateHelper::getStartOfMonth(),
            'endOfMonth' => DateHelper::getEndOfMonth(),
            'month' => DateHelper::getCurrentMonth(),
            'currentMonth' => DateHelper::getCurrentMonth(),
            'currentYear' => DateHelper::getCurrentYear(),
            'daysInMonth' => $daysInMonth,
            'daysPass' => $daysPass,
            'rangeMonth' => $daysInMonth ? round(($daysPass / $daysInMonth) * 100, 2) : 0,
        ];
    }

    public function getChartData(Restaurant $restaurants, Request $request): JsonResponse
    {
         $request->validate([
            'date_from' => 'nullable|date',
            'date_to'   => 'nullable|date|after_or_equal:date_from',
            'month'     => 'nullable|integer|between:1,12',
            'year'      => 'nullable|integer|min:2000|max:2100',
        ]);

        [$dateFrom, $dateTo, $month, $year] = $this->resolveDateRange($request);

        $daysInRange = $dateFrom->diffInDays($dateTo) + 1;

        $projection = Projection::where('month', $month)
        ->where('year', $year)
        ->where('restaurant_id', $restaurants->id)
        ->first();

        $cortes = Cheques::query()
            ->selectRaw('
                CONVERT(DATE, fecha) as dia,
                COUNT(*)             as total_cuentas,
                SUM(nopersonas)      as total_clientes,
                SUM(total)           as total_venta,
                SUM(totalimpuesto1)  as total_iva,
                SUM(subtotal)        as total_subtotal,
                SUM(efectivo)        as total_efectivo,
                SUM(propina)         as total_propina,
                SUM(tarjeta)         as total_tarjeta,
                SUM(descuento)       as total_descuento,
                SUM(totalalimentos)  as total_alimentos,
                SUM(totalbebidas)    as total_bebidas
            ')
            ->whereBetween('fecha', [$dateFrom->startOfDay(), $dateTo->endOfDay()])
            ->where('pagado', true)
            ->where('cancelado', false)
            ->groupBy(DB::raw('CONVERT(DATE, fecha)'))
            ->orderBy('dia')
            ->get();

        $chartData = $this->processChartData($cortes, $projection, $daysInRange);

        return response()->json([
            'success'    => true,
            'chartData'  => $chartData,
            'projection' => $projection,
            'summary'    => $chartData['summary'],
            'dateFrom'   => $dateFrom->format('Y-m-d'),
            'dateTo'     => $dateTo->format('Y-m-d'),
        ]);
    }

    private function resolveDateRange(Request $request): array
    {
        $year  = $request->year  ?? DateHelper::getCurrentYear();
        $month = $request->month ?? DateHelper::getCurrentMonth();

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $dateFrom = Carbon::parse($request->date_from);
            $dateTo   = Carbon::parse($request->date_to);
            $month    = $dateFrom->month;
            $year     = $dateFrom->year;
        } elseif ($request->filled('month') || $request->filled('year')) {
            $dateFrom = Carbon::create($year, $month, 1)->startOfMonth();
            $dateTo   = Carbon::create($year, $month, 1)->endOfMonth();
        } else {
            $dateFrom = Carbon::now()->startOfMonth();
            $dateTo   = Carbon::now()->endOfMonth();
        }

        return [$dateFrom, $dateTo, $month, $year];
    }

    private function processChartData($cortes, $projection, int $daysInRange): array
    {
        $days_total       = [];
        $days_total_food  = [];
        $days_total_drink = [];
        $days_total_client= [];
        $days_total_ticket= [];
        $proj_total       = [];
        $proj_avg         = [];
        $proj_check       = [];
        $proj_check_avg   = [];
        $labels           = [];

        $totalGral     = 0;
        $totalClientes = 0;
        $dayIndex      = 0;

        foreach ($cortes as $corte) {
            $dayIndex++;
            $venta    = floatval($corte->total_venta   ?? 0);
            $clientes = intval($corte->total_clientes  ?? 0);

            $totalGral     += $venta;
            $totalClientes += $clientes;

            $labels[]           = $corte->dia;
            $days_total[]       = $venta;
            $days_total_food[]  = floatval($corte->total_alimentos ?? 0);
            $days_total_drink[] = floatval($corte->total_bebidas   ?? 0);
            $days_total_client[]= $clientes;
            $days_total_ticket[]= $clientes > 0 ? round($venta / $clientes, 2) : 0;

            $proj_total[]      = round(($projection->projected_sales ?? 0) / $daysInRange, 2);
            $proj_avg[]        = $dayIndex > 0 ? round($totalGral / $dayIndex, 2) : 0;
            $proj_check[]      = floatval($projection->projected_check ?? 0);
            $proj_check_avg[]  = $totalClientes > 0 ? round($totalGral / $totalClientes, 2) : 0;
        }

        return [
            'labels'             => $labels,
            'days_total'         => $days_total,
            'days_total_food'    => $days_total_food,
            'days_total_drink'   => $days_total_drink,
            'days_total_client'  => $days_total_client,
            'days_total_ticket'  => $days_total_ticket,
            'projections_total'  => $proj_total,
            'projections_avg'    => $proj_avg,
            'projections_check'  => $proj_check,
            'projections_check_avg' => $proj_check_avg,
            'summary' => [
                'total_venta'    => $totalGral,
                'total_clientes' => $totalClientes,
                'ticket_promedio'=> $totalClientes > 0 ? round($totalGral / $totalClientes, 2) : 0,
                'total_dias'     => $dayIndex,
            ],
        ];
    }
  
 public function filter(?Business $business = null, ?Restaurant $restaurants = null, Request $request)
{
    // ── Determinar rango de fechas según modo ─────────────────────
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $start        = \Carbon\Carbon::parse($request->start_date)->startOfDay();
        $end          = \Carbon\Carbon::parse($request->end_date)->endOfDay();
        $daysInMonth  = $start->diffInDays($end) + 1;
        $daysPass     = $daysInMonth;
        $currentMonth = null;
        $currentYear  = null;
    } else {
        $currentMonth = $request->input('month', DateHelper::getCurrentMonth());
        $currentYear  = $request->input('year',  DateHelper::getCurrentYear());
        $start        = \Carbon\Carbon::create($currentYear, $currentMonth, 1)->startOfDay();
        $end          = $start->copy()->endOfMonth()->endOfDay();
        $daysInMonth  = $start->daysInMonth;
        $daysPass     = min((int) now()->format('j'), $daysInMonth);
    }

    // ── Proyecciones ──────────────────────────────────────────────
    $projections = null;
    if ($currentMonth && $currentYear) {
        $projections = Projection::where('month', $currentMonth)
            ->where('year', $currentYear)
            ->where('restaurant_id', $restaurants->id)
            ->first();
    }
    
    // ── Consulta de cortes ────────────────────────────────────────
    $cortes = Cheques::query()
        ->selectRaw('
            CONVERT(DATE, fecha) as dia,
            COUNT(*) as total_cuentas,
            SUM(nopersonas) as total_clientes,
            SUM(total) as total_venta,
            SUM(totalimpuesto1) as total_iva,
            SUM(subtotal) as total_subtotal,
            SUM(efectivo) as total_efectivo,
            SUM(propina) as total_propina,
            SUM(tarjeta) as total_tarjeta,
            SUM(descuento) as total_descuento,
            SUM(totalalimentos) as total_alimentos,
            SUM(totaldescuentoalimentos) as total_descuento_alimentos,
            SUM(totalbebidas) as total_bebidas,
            SUM(totaldescuentobebidas) as total_descuento_bebidas
        ')
        ->whereRaw("fecha BETWEEN ? AND ?", [
            $start->format('Y-m-d\TH:i:s'),
            $end->format('Y-m-d\TH:i:s'),
        ])
        ->where('pagado', true)
        ->where('cancelado', false)
        ->groupBy(DB::raw('CONVERT(DATE, fecha)'))
        ->orderBy('dia')
        ->get();

    // ── Preparar datos para alimentos y bebidas (food_drink_sales) ─
    $food_drink_sales = collect();
    foreach ($cortes as $corte) {
        $porcentaje_alimentos = $corte->total_venta > 0 
            ? round(($corte->total_alimentos * 100) / $corte->total_venta, 2) 
            : 0;
            
        $porcentaje_bebidas = $corte->total_venta > 0 
            ? round(($corte->total_bebidas * 100) / $corte->total_venta, 2) 
            : 0;

        $food_drink_sales->push((object)[
            'dia' => $corte->dia,
            'total_alimentos' => $corte->total_alimentos ?? 0,
            'descuento_alimentos' => $corte->total_descuento_alimentos ?? 0,
            'porcentaje_alimentos' => $porcentaje_alimentos,
            'total_bebidas' => $corte->total_bebidas ?? 0,
            'descuento_bebidas' => $corte->total_descuento_bebidas ?? 0,
            'porcentaje_bebidas' => $porcentaje_bebidas,
        ]);
    }

    // ── Indexar cortes por día para lookup rápido ─────────────────
    $cortesByDay = $cortes->keyBy(fn($c) => $c->dia);

    // ── Inicializar arrays ────────────────────────────────────────
    $daysInMonthLabels     = [];
    $days_total            = [];
    $days_total_food       = [];
    $days_total_drink      = [];
    $days_total_client     = [];
    $days_total_ticket     = [];
    $projections_total     = [];
    $projections_avg       = [];
    $projections_check     = [];
    $projections_check_avg = [];

    $totalGral     = 0;
    $totalClientes = 0;
    $dayIndex      = 0;

    // ── Iterar todos los días del rango (con o sin ventas) ────────
    $current = $start->copy()->startOfDay();
    while ($current->lte($end)) {
        $dayIndex++;
        $key   = $current->format('Y-m-d');
        $corte = $cortesByDay->get($key);

        $venta    = floatval($corte->total_venta    ?? 0);
        $clientes = intval($corte->total_clientes   ?? 0);

        $totalGral     += $venta;
        $totalClientes += $clientes;

        $daysInMonthLabels[]     = $current->format('Y-m-d');
        $days_total[]            = $venta;
        $days_total_food[]       = floatval($corte->total_alimentos ?? 0);
        $days_total_drink[]      = floatval($corte->total_bebidas   ?? 0);
        $days_total_client[]     = $clientes;
        $days_total_ticket[]     = $clientes > 0 ? round($venta / $clientes, 2) : 0;
        $projections_total[]     = round(($projections->projected_sales ?? 0) / $daysInMonth, 2);
        $projections_avg[]       = $dayIndex > 0 ? round($totalGral / $dayIndex, 2) : 0;
        $projections_check[]     = floatval($projections->projected_check ?? 0);
        $projections_check_avg[] = $totalClientes > 0 ? round($totalGral / $totalClientes, 2) : 0;

        $current->addDay();
    }

    // ── Calcular totales para tfoot ───────────────────────────────
    $totals = [
        'clientes'          => $cortes->sum('total_clientes'),
        'venta'             => $cortes->sum('total_venta'),
        'iva'               => $cortes->sum('total_iva'),
        'subtotal'          => $cortes->sum('total_subtotal'),
        'efectivo'          => $cortes->sum('total_efectivo'),
        'propina'           => $cortes->sum('total_propina'),
        'tarjeta'           => $cortes->sum('total_tarjeta'),
        'descuento'         => $cortes->sum('total_descuento'),
        'alimentos'         => $cortes->sum('total_alimentos'),
        'descuento_alimentos' => $cortes->sum('total_descuento_alimentos'),
        'bebidas'           => $cortes->sum('total_bebidas'),
        'descuento_bebidas' => $cortes->sum('total_descuento_bebidas'),
    ];

    // Calcular porcentajes promedio para alimentos y bebidas
    $totals['porcentaje_alimentos'] = $totals['venta'] > 0 
        ? round(($totals['alimentos'] * 100) / $totals['venta'], 2) 
        : 0;
    $totals['porcentaje_bebidas'] = $totals['venta'] > 0 
        ? round(($totals['bebidas'] * 100) / $totals['venta'], 2) 
        : 0;

    // ── Respuesta JSON ────────────────────────────────────────────
    return response()->json([
        'daysInMonth'           => $daysInMonthLabels,
        'days_total'            => $days_total,
        'days_total_food'       => $days_total_food,
        'days_total_drink'      => $days_total_drink,
        'days_total_client'     => $days_total_client,
        'days_total_ticket'     => $days_total_ticket,
        'projections_total'     => $projections_total,
        'projections_avg'       => $projections_avg,
        'projections_check'     => $projections_check,
        'projections_check_avg' => $projections_check_avg,
        
        // Vista de ventas principales
        'rowsVentas' => view('components.sales.monthly-sales-component', [
            'cortes' => $cortes,
            'restaurants' => $restaurants,
            'errors' => []
        ])->render(),
        
        // Vista de alimentos y bebidas usando food_drink_sales
        'rowsFoodDrink' => view('components.sales.monthly-sales-food', [
            'food_drink_sales' => $food_drink_sales,
            'restaurants' => $restaurants
        ])->render(),
        
        'totals' => $totals,
    ]);
}
}

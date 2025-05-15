<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Projection;
use App\Models\Restaurant;
use App\Models\Sfrt\Cheques;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Business $business, Restaurant $restaurants, Request $request)
    {
            $day = Carbon::now(); // Esto conserva la fecha como objeto Carbon
            $startOfMonth = Carbon::now()->startOfMonth()->format('d-m-y');
            $endOfMonth = Carbon::now()->endOfMonth()->format('d-m-y');
            $month = Carbon::now()->translatedFormat('F');
            $daysInMonth = Carbon::now()->daysInMonth;
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $daysPass = $day->day - 1;
            $rangeMonth = round(($daysPass / $daysInMonth) * 100, 2);
            $restaurant = $restaurants;
            $projections = Projection::where('month', $currentMonth)
                                        ->where('year', $currentYear)
                                        ->where('restaurant_id', $restaurants->id)
                                        ->first();
            // $currentMonth = Carbon::now()->month;
            // $currentYear = Carbon::now()->year;
            // $dayofMonth = CarbonPeriod::create(
            //     Carbon::now()->startOfMonth(),
            //     Carbon::now()->endOfMonth()
            // );
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
                SUM(otros) as total_otros,
                SUM(totalalimentos) as total_alimentos,
                SUM(totaldescuentoalimentos) as total_dalimentos,
                SUM(totalbebidas) as total_bebidas,
                SUM(totaldescuentobebidas) as total_dbebidas,
                SUM(descuentoimporte) as total_descuento
            ')
            ->whereYear('fecha', $currentYear)
            ->whereMonth('fecha', $currentMonth)
            ->where('pagado', true)
            ->where('cancelado', false)
            ->groupBy(DB::raw('CONVERT(DATE, fecha)'))
            ->orderBy('dia')
            ->get();

            $days = [];
            $days_total = [];
            $days_total_food = [];
            $days_total_drink = [];
            $days_total_client = [];
            $days_total_ticket = [];
            $projections_total = [];
            $projections_avg = [];
            $totalGeneral = [];
            $totalGral = 0;
            $totalClientes = 0;
            $projections_check = [];
            $projections_check_avg = [];

            foreach ($cortes as $i => $day) {
                // Ya puedes acceder directamente a los valores de $day
                $days_total[] = $day->total_venta ?: 0;
                $totalGral += $day->total_venta;
                $totalClientes += $day->total_clientes;

                $days_total_food[] = $day->total_alimentos ?: 0;
                $days_total_drink[] = $day->total_bebidas ?: 0;
                $days_total_client[] = $day->total_clientes ?: 0;
            
                // Calculamos el promedio por ticket (evitar división por cero)
                $days_total_ticket[] = ($day->total_clientes && $day->total_clientes > 0) ? round($day->total_venta / $day->total_clientes, 2) : 0;
                
                //Proyecciones 
                $projections_total[] =  round($projections->projected_sales / ($daysInMonth + 0),2);
                $projections_avg[] =  round($totalGral / $daysPass ,2);
                $projections_check[] = floatval($projections->projected_check);
                $projections_check_avg[] = $totalClientes > 0 ? round(($totalGral / $totalClientes), 2) : 0;
             }

        return view('home.index', compact(
            'day',
            'days',
            'days_total',
            'days_total_food',
            'days_total_drink',
            'days_total_client',
            'days_total_ticket',
            'projections_total',
            'projections_avg',
            'projections_check',
            'projections_check_avg',
            'startOfMonth',
            'endOfMonth',
            'month',
            'daysInMonth',
            'currentMonth',
            'currentYear',
            'daysPass',
            'rangeMonth',
            'restaurant',
            'cortes',
            'projections',
            
        ));
    }
}

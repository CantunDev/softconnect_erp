<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Sfrt\Cheques;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
    //    return 'Bienvenido' . $request->route('business');
            $day = Carbon::now(); // Esto conserva la fecha como objeto Carbon
            $startOfMonth = Carbon::now()->startOfMonth()->format('d-m-y');
            $endOfMonth = Carbon::now()->endOfMonth()->format('d-m-y');
            $month = Carbon::now()->translatedFormat('F');
            $daysInMonth = Carbon::now()->daysInMonth;
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $daysPass = $day->day - 1;
            $rangeMonth = round(($daysPass / $daysInMonth) * 100, 2);

            $restaurant = Restaurant::where('id', $request->route('business'))->first();
           
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
                SUM(totalbebidas) as total_bebidas
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

            foreach ($cortes as $day) {
                // Ya puedes acceder directamente a los valores de $day
                $days_total[] = $day->total_venta ?: 0;
                $days_total_food[] = $day->total_alimentos ?: 0;
                $days_total_drink[] = $day->total_bebidas ?: 0;
                $days_total_client[] = $day->total_clientes ?: 0;
            
                // Calculamos el promedio por ticket (evitar división por cero)
                $days_total_ticket[] = ($day->total_clientes && $day->total_clientes > 0)
                ? round($day->total_venta / $day->total_clientes, 2)
                : 0;
            
            }

        return view('home.index', compact(
            'day',
            'days',
            'days_total',
            'days_total_food',
            'days_total_drink',
            'days_total_client',
            'days_total_ticket',
            'startOfMonth',
            'endOfMonth',
            'month',
            'daysInMonth',
            'currentMonth',
            'currentYear',
            'daysPass',
            'rangeMonth',
            'restaurant',
            'cortes'
        ));
    }
}

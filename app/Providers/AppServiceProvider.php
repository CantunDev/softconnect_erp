<?php

namespace App\Providers;

use App\Models\Sfrt\Cheques;
use App\Models\Sfrt\Group;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Carbon\CarbonPeriod;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // DB::listen(function ($query) {
        //     logger($query->sql);
        //     logger($query->bindings);
        // });
        // Implicitly grant "Super-Admin" role all permission checks using can()
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('Super-Admin')) {
                return true;
            }
        });

        view()->composer(['layouts.master','dashboard'], function($view){
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $dayofMonth = CarbonPeriod::create(
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            );

            $clients_sum = Cheques::whereMonth('fecha', $currentMonth)
                            ->whereYear('fecha', $currentYear)
                            ->where('pagado', true)
                            ->where('cancelado', false)
                            ->sum('nopersonas');

            $total_sum = Cheques::whereMonth('fecha', $currentMonth)
                            ->whereYear('fecha', $currentYear)
                            ->where('pagado', true)
                            ->where('cancelado', false)
                            ->sum('total');

            $tickets_avg = round($total_sum/$clients_sum);
            $cortes = Cheques::query()
            ->selectRaw('
                CONVERT(DATE, fecha) as dia,
                SUM(nopersonas) as total_clientes,
                SUM(total) as total_venta,
                SUM(totalimpuesto1) as total_iva,
                SUM(subtotal) as total_subtotal,
                SUM(efectivo) as total_efectivo,
                SUM(efectivo) as total_propina,
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
            
            // $food = Cheques::query()
            //     ->selectRaw('
            //     CONVERT(DATE, fecha) as dia,
            //     SUM(totalalimentos) as totalalimentos')
            //     ->whereYear('fecha', $currentYear)
            //     ->whereMonth('fecha', $currentMonth)
            //     ->where('pagado', true)
            //     ->where('cancelado', false)
            //     ->groupBy(DB::raw('CONVERT(DATE, fecha)'))
            //     ->orderBy('dia')
            //     ->get();
            $food_sum = Cheques::whereMonth('fecha', $currentMonth)
                        ->whereYear('fecha', $currentYear)
                        ->where('pagado', true)
                        ->where('cancelado', false)
                        ->sum('totalalimentos');


            $drink_sum = Cheques::whereMonth('fecha', $currentMonth)
                    ->whereYear('fecha', $currentYear)
                    ->where('pagado', true)
                    ->where('cancelado', false)
                    ->sum('totalbebidas');

            $total_food_drink = $food_sum + $drink_sum;

                // Validar para evitar división por cero
                if ($total_food_drink > 0) {
                    $food_percentage = round(($food_sum / $total_food_drink) * 100, 2);
                    $drink_percentage = round(($drink_sum / $total_food_drink) * 100, 2);
                } else {
                    $food_percentage = 0;
                    $drink_percentage = 0;
                }
            
            $groups = Group::with(['products.cheques_details' => function($query) use ($currentMonth, $currentYear){
                $query->whereYear('hora',$currentYear)
                       ->whereMonth('hora', $currentMonth); 
            }])
            ->orderBy('descripcion','ASC')
            ->get()
            ->map(function($group) use ($total_sum){
                $total_sales = $group->products->sum(function($product){
                        return $product->cheques_details->sum('precio');
                    });
                return [
                    'descripcion' => $group->descripcion,
                    'count_products' => $group->products->sum(function($product){
                        return $product->cheques_details->count('idproducto');
                    }),
                    // 'total_sales' => $group->products->sum(function($product){
                    //     return $product->cheques_details->sum('precio');
                    // }),
                    'total_sales' => $total_sales,
                    'total_subtotal' => $group->products->sum(function($product){
                        return $product->cheques_details->sum('preciosinimpuestos');
                    }),
                    'total_discount' => $group->products->sum(function($product){
                        return $product->cheques_details->sum('descuento');
                    }),
                    'avg_total' => $total_sum > 0 ? round(($total_sales / $total_sum) * 100,2) : 0,
                ];
            });

            $view->with([
                // 'clients_avg' => number_format($clients_avg,2),
                'cortes' => $cortes,
                'tickets_avg' => $tickets_avg,
                'currentMonth' => $currentMonth,
                'clients_sum' => $clients_sum,
                'days' => $days,
                'days_total_food' => $days_total_food,
                'days_total_drink' => $days_total_drink,
                'days_total_client' => $days_total_client,
                'days_total_ticket' => $days_total_ticket,
                'days_total' => $days_total,
                'food_sum' => round($food_sum,2),
                'food_percentage' =>$food_percentage,
                'drink_sum' => round($drink_sum,2),
                'drink_percentage' => $drink_percentage,
                'groups' => $groups,
            ]);
        });

    }
}

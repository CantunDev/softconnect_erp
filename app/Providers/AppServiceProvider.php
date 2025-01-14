<?php

namespace App\Providers;

use App\Models\Sfrt\Cheques;
use App\Models\Sfrt\Group;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

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
            $day = Carbon::now(); // Esto conserva la fecha como objeto Carbon
            $startOfMonth = Carbon::now()->startOfMonth()->format('d-m-y');
            $endOfMonth = Carbon::now()->endOfMonth()->format('d-m-y');
            $month = Carbon::now()->translatedFormat('F');
            $daysInMonth = Carbon::now()->daysInMonth;
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            // $daysPass = $day->diffInDays($day->startOfMonth()) + 1;
            $daysPass = $day->day - 1;  
            $rangeMonth = round(($daysPass/$daysInMonth) * 100, 2); 
            if (Auth::check()) {
                $user = Auth::user();
                $restaurants = $user->restaurants;
                    // Array para almacenar las conexiones dinámicas
                $connections = [];
                foreach ($restaurants as $restaurant) {
                    $connectionName = "restaurant_{$restaurant->id}";
                        // Configurar la conexión dinámica para cada restaurante
                    Config::set("database.connections.{$connectionName}", [
                        'driver' => 'sqlsrv',
                        'host' => $restaurant->ip .'\NATIONALSOFT' ?? '192.168.193.29\NATIONALSOFT',
                        'database' => $restaurant->database ?? 'softrestaurant10',
                        'username' => 'sa', // Reemplaza con el usuario real
                        'password' => 'National09', // Reemplaza con la contraseña real
                        'prefix_indexes' => true,
                        'encrypt' => env('DB_ENCRYPT', 'no'), // Cambiar a 'yes' si se requiere conexión cifrada
                        'trust_server_certificate' => env('DB_TRUST_CERTIFICATE', true),
                        'strict' => false,
                    ]);
                    // Purge para evitar conflictos con configuraciones anteriores
                    DB::purge($connectionName);
                    // Agregar la conexión al array
                    $connections[$restaurant->id] = DB::connection($connectionName);
                }
    
                // Realizar consultas necesarias y compartir resultados con la vista
                $results = collect();
    
                foreach ($connections as $i => $connection) {
                    // $results->push(
                    //     $connection->table('cheques')->whereMonth('fecha', $currentMonth)
                    //     ->whereYear('fecha', $currentYear)
                    //     ->where('pagado', true)
                    //     ->where('cancelado', false)
                    //     ->sum('total')
                    // );
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
                    
                    $chequePromedio = round(($total/$nopersonas),2);
                // Agregar el resultado al collection con un nombre personalizado
                    $results->put("venta$i",[
                        'total' => $total,
                        'nopersonas' => $nopersonas,
                        'chequePromedio' => $chequePromedio
                    ]);
                }
            }
               


            $view->with([
                // 'clients_avg' => number_format($clients_avg,2),
                'startOfMonth' => $startOfMonth,
                'endOfMonth' => $endOfMonth,
                'month' => $month,
                'daysInMonth' => $daysInMonth,
                'daysPass' => $daysPass,
                'rangeMonth' => $rangeMonth, 
                'restaurants' => $restaurants,
                'results' => $results
            ]);
        });
        
    }
}

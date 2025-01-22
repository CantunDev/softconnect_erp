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
                $resultsTemp = collect();
                
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

                    $lastTurno = $connection->table('cheques')
    ->select('idturno', 'fecha')
    ->orderBy('cierre', 'desc') // Ordenar por el cierre más reciente
    ->first();

// Obtener el último turno de la tabla 'turnos_temp'
$lastTurnoTemp = $connection->table('tempcheques')
    ->select('idturno', 'fecha')
    ->orderBy('cierre', 'desc') // Ordenar por el cierre más reciente
    ->first();

// Validar si ambos resultados existen
if ($lastTurno && $lastTurnoTemp) {
    // Comparar los valores de 'idturno'
    if ($lastTurno->idturno === $lastTurnoTemp->idturno) {
        // Ambos coinciden: usar la tabla 'cheques'
        $tabla = 'cheques';
        $dateCheque = Carbon::parse($lastTurno->fecha)->toDateTimeString();
    } else {
        // No coinciden: usar la tabla 'tempcheques'
        $tabla = 'tempcheques';
        $dateCheque = Carbon::parse($lastTurnoTemp->fecha)->toDateTimeString();
    }
} elseif ($lastTurno) {
    // Si solo existe $lastTurno
    $tabla = 'cheques';
    $dateCheque = Carbon::parse($lastTurno->fecha)->toDateTimeString();
} elseif ($lastTurnoTemp) {
    // Si solo existe $lastTurnoTemp
    $tabla = 'tempcheques';
    $dateCheque = Carbon::parse($lastTurnoTemp->fecha)->toDateTimeString();
} else {
    // Si no hay turnos en ninguna tabla
    $tabla = 'tempcheques';
    $dateCheque = null;
}

                    $totalTemp = $connection->table($tabla)
                        ->whereMonth('fecha', $currentMonth) // Filtrar por el mes actual
                        ->whereYear('fecha', $currentYear)  // Filtrar por el año actual
                        ->whereDate('fecha', $dateCheque) // Filtrar específicamente por el día de hoy
                        // ->where('pagado', true) // Solo cheques pagados
                        ->where('cancelado', false) // Excluir cheques cancelados
                        ->sum('total');
                    $totalPaidTemp = $connection->table($tabla)
                        ->whereMonth('fecha', $currentMonth) // Filtrar por el mes actual
                        ->whereYear('fecha', $currentYear)  // Filtrar por el año actual
                        ->whereDate('fecha', $dateCheque) // Filtrar específicamente por el día de hoy
                        ->where('pagado', true) // Solo cheques pagados
                        ->where('cancelado', false) // Excluir cheques cancelados
                        ->sum('total');
                    $nopersonasTemp = $connection->table($tabla)
                        ->whereMonth('fecha', $currentMonth) // Filtrar por el mes actual
                        ->whereYear('fecha', $currentYear)  // Filtrar por el año actual
                        ->whereDate('fecha',$dateCheque) // Filtrar específicamente por el día de hoy
                        // ->where('pagado', true) // Solo cheques pagados
                        ->where('cancelado', false) // Excluir cheques cancelados
                        ->sum('nopersonas');
                    $descuentosTemp = $connection->table($tabla)
                        ->whereMonth('fecha', $currentMonth) // Filtrar por el mes actual
                        ->whereYear('fecha', $currentYear)  // Filtrar por el año actual
                        ->whereDate('fecha', $dateCheque) // Filtrar específicamente por el día de hoy
                        // ->where('pagado', true) // Solo cheques pagados
                        ->where('cancelado', false) // Excluir cheques cancelados
                        ->sum('descuentoimporte');
                    $alimentosTemp = $connection->table($tabla)
                        ->whereMonth('fecha', $currentMonth) // Filtrar por el mes actual
                        ->whereYear('fecha', $currentYear)  // Filtrar por el año actual
                        ->whereDate('fecha',$dateCheque) // Filtrar específicamente por el día de hoy
                        // ->where('pagado', true) // Solo cheques pagados
                        ->where('cancelado', false) // Excluir cheques cancelados
                        ->sum('totalalimentos');
                    $bebidasTemp = $connection->table($tabla)
                        ->whereMonth('fecha', $currentMonth) // Filtrar por el mes actual
                        ->whereYear('fecha', $currentYear)  // Filtrar por el año actual
                        ->whereDate('fecha', $dateCheque) // Filtrar específicamente por el día de hoy
                        // ->where('pagado', true) // Solo cheques pagados
                        ->where('cancelado', false) // Excluir cheques cancelados
                        ->sum('totalbebidas');

                        // if ($totalTemp != 0) {
                            if ($nopersonasTemp > 0) {
                                $chequePromedioTemp = round(($totalTemp / $nopersonasTemp), 2);
                            } else {
                                $chequePromedioTemp = 0; // O un valor predeterminado que tenga sentido
                            }                        // } 
                 

                // Agregar el resultado al collection con un nombre personalizado
                    $results->put("venta$i",[
                        'total' => round($total,2),
                        'nopersonas' => $nopersonas,
                        'chequePromedio' => $chequePromedio,
                        'last' => $lastTurno
                    ]);

                    $resultsTemp->put("venta$i", [
                        'totalTemp' => round($totalTemp,2), 
                        'nopersonasTemp' => $nopersonasTemp,
                        'descuentosTemp' => round($descuentosTemp,2),
                        'totalPaidTemp' => round($totalPaidTemp,2),
                        'alimentosTemp' => $alimentosTemp,
                        'bebidasTemp' => $bebidasTemp,
                        'chequePromedioTemp' => $chequePromedioTemp,
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
                'results' => $results,
                'resultsTemp' => $resultsTemp
            ]);
        });
        
    }
}

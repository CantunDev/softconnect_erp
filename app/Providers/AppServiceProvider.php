<?php

namespace App\Providers;

use App\Helpers\DateHelper;
use App\Models\Sfrt\Cheques;
use App\Models\Sfrt\Group;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Schema;

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
        // Schema::defaultStringLength(191);
        Schema::defaultStringLength(125);
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

        // view()->composer('*', function ($view) {
        view()->composer(['layouts.master', 'dashboard'], function ($view) {

            // $user = Auth::user();

            // $day = Carbon::now(); // Esto conserva la fecha como objeto Carbon
            // $startOfMonth = Carbon::now()->startOfMonth()->format('d-m-y');
            // $endOfMonth = Carbon::now()->endOfMonth()->format('d-m-y');
            // $month = Carbon::now()->translatedFormat('F');
            // $daysInMonth = Carbon::now()->daysInMonth;
            // $currentMonth = Carbon::now()->month;
            // $currentYear = Carbon::now()->year;
            // // $daysPass = $day->diffInDays($day->startOfMonth()) + 1;
            // $daysPass = $day->day - 1;
            // $rangeMonth = round(($daysPass / $daysInMonth) * 100, 2);
            // if (Auth::check()) {
            //     $restaurants = $user->restaurants;
            //     // Array para almacenar las conexiones dinámicas
            //     $connections = [];
            //     foreach ($restaurants as $restaurant) {
            //         $connectionName = "restaurant_{$restaurant->id}";
            //          try {
            //             // Configurar la conexión dinámica para cada restaurante
            //         Config::set("database.connections.{$connectionName}", [
            //             'driver' => 'sqlsrv',
            //             'host' => $restaurant->ip . '\NATIONALSOFT' ?? '192.168.193.29\NATIONALSOFT',
            //             'database' => $restaurant->database ?? 'softrestaurant10',
            //             'username' => 'sa', // Reemplaza con el usuario real
            //             'password' => 'National09', // Reemplaza con la contraseña real
            //             'prefix_indexes' => true,
            //             'encrypt' => env('DB_ENCRYPT', 'no'), // Cambiar a 'yes' si se requiere conexión cifrada
            //             'trust_server_certificate' => env('DB_TRUST_CERTIFICATE', 'no'),
            //             'strict' => false,
            //         ]);
            //         // Purge para evitar conflictos con configuraciones anteriores
            //         DB::purge($connectionName);
            //         // Agregar la conexión al array
            //         $connections[$restaurant->id] = DB::connection($connectionName);
            //          } catch (\Exception $e) {
            //             \Log::error("Error en la conexion $restaurant: ". $e->getMessage());
            //             $connections[$restaurant->id] = null;
            //          }
            //     }

            //     // Realizar consultas necesarias y compartir resultados con la vista
            //     $results = collect();
            //     $resultsTemp = collect();

            //     $totalGeneral = 0;
            //     $nopersonasGeneral = 0;
            //     $chequePromedioSum = 0;
            //     $chequePromedioFinal = 0;

            //     foreach ($connections as $i => $connection) {
            //         $total = $connection->table('cheques')
            //             ->whereMonth('fecha', $currentMonth)
            //             ->whereYear('fecha', $currentYear)
            //             ->where('pagado', true)
            //             ->where('cancelado', false)
            //             ->sum('total');

            //         $nopersonas = $connection->table('cheques')
            //             ->whereMonth('fecha', $currentMonth)
            //             ->whereYear('fecha', $currentYear)
            //             ->where('pagado', true)
            //             ->where('cancelado', false)
            //             ->sum('nopersonas');

            //         $chequePromedio = $nopersonas > 0 ? round(($total / $nopersonas), 2) : 0;

            //         $lastTurno = $connection->table('cheques')
            //             ->select('idturno', 'fecha')
            //             ->orderBy('fecha', 'desc')
            //             ->first();

            //         $lastTurnoTemp = $connection->table('tempcheques')
            //             ->select('idturno', 'fecha')
            //             ->orderBy('fecha', 'desc')
            //             ->first();

            //         $turno = [];
            //         $tabla = null;
            //         $dateCheque = null;

            //         // Si existen ambos registros, decidir cuál usar
            //         if ($lastTurno && $lastTurnoTemp) {
            //             // Comparar fechas para obtener el más reciente
            //             if (Carbon::parse($lastTurno->fecha)->gt(Carbon::parse($lastTurnoTemp->fecha))) {
            //                 // Si el de 'cheques' es más reciente, significa que el turno ya fue cerrado
            //                 $tabla = 'cheques';
            //                 $turno = 'Cerrado';
            //                 $dateCheque = Carbon::parse($lastTurno->fecha)->toDateTimeString();
            //             } else {
            //                 // Si el de 'tempcheques' es más reciente, el turno sigue abierto
            //                 $tabla = 'tempcheques';
            //                 $turno = 'Abierto';
            //                 $dateCheque = Carbon::parse($lastTurnoTemp->fecha)->toDateTimeString();
            //             }
            //         } elseif ($lastTurno) {
            //             // Si solo hay un turno cerrado
            //             $tabla = 'cheques';
            //             $turno = 'Cerrado';
            //             $dateCheque = Carbon::parse($lastTurno->fecha)->toDateTimeString();
            //         } elseif ($lastTurnoTemp) {
            //             // Si solo hay un turno abierto
            //             $tabla = 'tempcheques';
            //             $turno = 'Abierto';
            //             $dateCheque = Carbon::parse($lastTurnoTemp->fecha)->toDateTimeString();
            //         } else {
            //             // No hay turnos registrados
            //             $tabla = 'tempcheques';
            //             $turno = 'Abierto';
            //             $dateCheque = null;
            //         }

            //         $totalTemp = $connection->table($tabla)
            //             ->whereMonth('fecha', $currentMonth) // Filtrar por el mes actual
            //             ->whereYear('fecha', $currentYear)  // Filtrar por el año actual
            //             ->whereDate('fecha', $dateCheque) // Filtrar específicamente por el día de hoy
            //             // ->where('pagado', true) // Solo cheques pagados
            //             ->where('cancelado', false) // Excluir cheques cancelados
            //             ->sum('total');
            //         $totalPaidTemp = $connection->table($tabla)
            //             ->whereMonth('fecha', $currentMonth) // Filtrar por el mes actual
            //             ->whereYear('fecha', $currentYear)  // Filtrar por el año actual
            //             ->whereDate('fecha', $dateCheque) // Filtrar específicamente por el día de hoy
            //             ->where('pagado', true) // Solo cheques pagados
            //             ->where('cancelado', false) // Excluir cheques cancelados
            //             ->sum('total');
            //         $nopersonasTemp = $connection->table($tabla)
            //             ->whereMonth('fecha', $currentMonth) // Filtrar por el mes actual
            //             ->whereYear('fecha', $currentYear)  // Filtrar por el año actual
            //             ->whereDate('fecha', $dateCheque) // Filtrar específicamente por el día de hoy
            //             ->where('pagado', false) // Solo cheques pagados
            //             ->where('cancelado', false) // Excluir cheques cancelados
            //             ->sum('nopersonas');
            //         $noclientesTemp = $connection->table($tabla)
            //             ->whereMonth('fecha', $currentMonth) // Filtrar por el mes actual
            //             ->whereYear('fecha', $currentYear)  // Filtrar por el año actual
            //             ->whereDate('fecha', $dateCheque) // Filtrar específicamente por el día de hoy
            //             ->where('pagado', true) // Solo cheques pagados
            //             ->where('cancelado', false) // Excluir cheques cancelados
            //             ->sum('nopersonas');
            //         $totalclientesTemp = $connection->table($tabla)
            //             ->whereMonth('fecha', $currentMonth) // Filtrar por el mes actual
            //             ->whereYear('fecha', $currentYear)  // Filtrar por el año actual
            //             ->whereDate('fecha', $dateCheque) // Filtrar específicamente por el día de hoy
            //             // ->where('pagado', true) // Solo cheques pagados
            //             ->where('cancelado', false) // Excluir cheques cancelados
            //             ->sum('nopersonas');
            //         $descuentosTemp = $connection->table($tabla)
            //             ->whereMonth('fecha', $currentMonth) // Filtrar por el mes actual
            //             ->whereYear('fecha', $currentYear)  // Filtrar por el año actual
            //             ->whereDate('fecha', $dateCheque) // Filtrar específicamente por el día de hoy
            //             // ->where('pagado', true) // Solo cheques pagados
            //             ->where('cancelado', false) // Excluir cheques cancelados
            //             ->sum('descuentoimporte');
            //         $alimentosTemp = $connection->table($tabla)
            //             ->whereMonth('fecha', $currentMonth) // Filtrar por el mes actual
            //             ->whereYear('fecha', $currentYear)  // Filtrar por el año actual
            //             ->whereDate('fecha', $dateCheque) // Filtrar específicamente por el día de hoy
            //             // ->where('pagado', true) // Solo cheques pagados
            //             ->where('cancelado', false) // Excluir cheques cancelados
            //             ->sum('totalalimentos');
            //         $bebidasTemp = $connection->table($tabla)
            //             ->whereMonth('fecha', $currentMonth) // Filtrar por el mes actual
            //             ->whereYear('fecha', $currentYear)  // Filtrar por el año actual
            //             ->whereDate('fecha', $dateCheque) // Filtrar específicamente por el día de hoy
            //             // ->where('pagado', true) // Solo cheques pagados
            //             ->where('cancelado', false) // Excluir cheques cancelados
            //             ->sum('totalbebidas');

            //         // if ($totalTemp != 0) {
            //         if ($totalclientesTemp > 0) {
            //             $chequePromedioTemp = round(($totalTemp / $totalclientesTemp), 2);
            //         } else {
            //             $chequePromedioTemp = 0; // O un valor predeterminado que tenga sentido
            //         }                        // } 

            //         $totalGeneral += $total;
            //         $nopersonasGeneral += $nopersonas;

            //         $chequePromedioFinal = $nopersonasGeneral > 0 ? round(($totalGeneral / $nopersonasGeneral), 2) : 0;


            //         $results->put("venta$i", [
            //             'total' => round($total, 2),
            //             'nopersonas' => $nopersonas,
            //             'chequePromedio' => $chequePromedio,
            //             'last' => $lastTurno,
            //         ]);

            //         $resultsTemp->put("venta$i", [
            //             'totalTemp' => round($totalTemp, 2),
            //             'nopersonasTemp' => $nopersonasTemp,
            //             'noclientesTemp' => $noclientesTemp,
            //             'totalclientesTemp' => $totalclientesTemp,
            //             'descuentosTemp' => round($descuentosTemp, 2),
            //             'totalPaidTemp' => round($totalPaidTemp, 2),
            //             'alimentosTemp' => $alimentosTemp,
            //             'bebidasTemp' => $bebidasTemp,
            //             'chequePromedioTemp' => $chequePromedioTemp,
            //             'turno' => $turno,
            //         ]);
            //     }
            // }



            // $view->with([
            //     // 'clients_avg' => number_format($clients_avg,2),
            //     'startOfMonth' => DateHelper::getStartOfMonth(),
            //     'endOfMonth' => DateHelper::getEndOfMonth(),
            //     'month' => DateHelper::getCurrentMonth(),
            //     'daysInMonth' => DateHelper::getDaysInMonth(),
            //     'daysPass' => DateHelper::getDaysPassed(),
            //     'rangeMonth' => DateHelper::getMonthProgress(),
            //     'restaurants' => $restaurants,
            //     'results' => $results,
            //     'resultsTemp' => $resultsTemp,
            //     'totalGeneral' => $totalGeneral,
            //     'nopersonasGeneral' => $nopersonasGeneral,
            //     'chequePromedioGeneral' => $chequePromedioFinal,

            // ]);
        });
    }
}

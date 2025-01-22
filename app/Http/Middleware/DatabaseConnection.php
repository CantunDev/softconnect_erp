<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DatabaseConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if ($request->hasSession() && $request->user()) {
        //     $user = $request->user();

        //     // Configuración dinámica de sqlsrv si el usuario tiene restaurante
        //     $ip = $user->restaurants->ip ?? 'default_sqlsrv_ip';
        //     $database = $user->restaurants->database ?? 'default_sqlsrv_database';

        //     Config::set('database.connections.sqlsrv.host', $ip);
        //     Config::set('database.connections.sqlsrv.database', $database);

        //     // Limpia la conexión sqlsrv para aplicar los cambios
        //     DB::purge('sqlsrv');
        // }

        // // Siempre configura la conexión predeterminada como mysql
        // config(['database.default' => 'mysql']);

        // return $next($request);

        config(['database.default' => 'mysql']);
        if ($request->user()) {
            $user = $request->user();
            $restaurant = $user->restaurants->first(); 
            if ($restaurant) {
                $ip = $restaurant->ip ?? 'default_sqlsrv_ip';
                $database = $restaurant->database ?? 'default_sqlsrv_database';
                Config::set('database.connections.sqlsrv.host', $ip);
                Config::set('database.connections.sqlsrv.database', $database);
                DB::purge('sqlsrv');
            }
        }

        return $next($request);
    }
}

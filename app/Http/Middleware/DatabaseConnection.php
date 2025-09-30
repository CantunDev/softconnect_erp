<?php

namespace App\Http\Middleware;

use App\Models\Restaurant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        config(['database.default' => 'mysql']);

        $businessSlug = $request->route('business');
        $restaurantSlug = $request->route('restaurants');

        if ($businessSlug) {
            $restaurant = $restaurantSlug;
            if ($restaurant) {
                Log::info("Restaurante encontrado: {$restaurant->name}");            
                $ip = $restaurant->ip ?? env('DEFAULT_SQLSRV_IP', '192.168.193.29\NATIONALSOFT');
                $database = $restaurant->database ?? env('DEFAULT_SQLSRV_DATABASE', 'softrestaurant10');
                Log::info("Configurando conexión SQLSRV: IP={$ip}, DB={$database}");            
                $sessionKey = "{$ip}_{$database}";
                // Cerrar la sesión y la conexión actual antes de reconfigurar
                if (session('sqlsrv_configured')) {
                    Log::info("Cerrando conexión SQLSRV y limpiando sesión.");
                    try {
                        DB::disconnect('sqlsrv'); // Cerrar la conexión actual
                    } catch (\Exception $e) {
                        Log::warning("No se pudo cerrar la conexión SQLSRV: " . $e->getMessage());
                    }
                    session()->forget('sqlsrv_configured'); // Limpiar la sesión
                }
                // Configurar la nueva conexión
                config([
                    'database.connections.sqlsrv.host' => $ip,
                    'database.connections.sqlsrv.database' => $database,
                ]);
            
                DB::purge('sqlsrv'); // Limpiar la conexión anterior
                DB::reconnect('sqlsrv'); // Forzar reconexión con la nueva configuración
                // Actualizar la sesión con la nueva configuración
                session(['sqlsrv_configured' => $sessionKey]);
                Log::info("Conexión SQLSRV configurada y sesión actualizada.");
            } else {
                Log::warning("Restaurante no encontrado para el id: {$restaurantSlug}");
                // Cerrar la conexión y limpiar la sesión si no se encuentra el restaurante
                try {
                    DB::disconnect('sqlsrv');
                    session()->forget('sqlsrv_configured');
                    Log::info("Conexión SQLSRV cerrada y sesión limpiada.");
                } catch (\Exception $e) {
                    Log::warning("No se pudo cerrar la conexión SQLSRV: " . $e->getMessage());
                }
            }
        }
        return $next($request);
    }
}

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
    public function handle(Request $request, Closure $next)
{
    config(['database.default' => 'mysql']);

    $restaurant =
        $request->route('restaurant') ??
        $request->route('restaurants');

    if ($restaurant) {

        Log::info("SQLSRV dinámico", [
            'ip' => $restaurant->ip,
            'database' => $restaurant->database,
        ]);

        if (!$restaurant->ip || !$restaurant->database) {
            throw new \Exception("Restaurant sin IP o DB");
        }

        config([
            'database.connections.sqlsrv.host' => $restaurant->ip,
            'database.connections.sqlsrv.database' => $restaurant->database,
            'database.connections.sqlsrv.username' => 'sa',
            'database.connections.sqlsrv.password' => 'National09',
        ]);

        DB::disconnect('sqlsrv');
        DB::purge('sqlsrv');
        DB::reconnect('sqlsrv');
    }

    return $next($request);
}
}

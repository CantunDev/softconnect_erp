<?php

namespace App\Http\Controllers;

use App\Services\DatabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConnectionSQLController extends Controller
{
    protected $databaseService;

    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
    }

    public function connection(Request $request, $ip, $database,$tabla)
    {
        $columnas = $request->input('columnas') ? explode(',', $request->input('columnas')) : ['*'];
        $results = $this->databaseService->ejecutarConsultaDinamica($ip, $database, $tabla, $columnas);

        return response()->json($results);
    }
}
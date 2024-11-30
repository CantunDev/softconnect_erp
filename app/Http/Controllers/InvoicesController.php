<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DatabaseService;
use Illuminate\Support\Facades\DB;
use App\Models\InvoiceSfrt;
use App\Models\Sfrt\Invoice;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Config;

class InvoicesController extends Controller
{
    protected $connectService;

    public function __construct(DatabaseService $connectService)
    {
        $this->connectService = $connectService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // try {
        //     DB::connection()->getPdo();
        //     return "Conexión exitosa a la base de datos: " . DB::connection('sqlsrv')->getDatabaseName();
        // } catch (\Exception $e) {
        //     return "Error en la conexión: " . $e->getMessage();
        // }
        //  return $facturas = DB::connection('sqlsrv')->table('facturas')->paginate(100); // Uses SQL Server
        $ip = '192.168.193.73\NATIONALSOFT';
        $database = 'softrestaurant11';
        Config::set('database.connections.sqlsrv.host', $ip);
        Config::set('database.connections.sqlsrv.database', $database);
        DB::purge('sqlsrv');
        InvoiceSfrt::setDynamicConnection('sqlsrv');

        // $columnas = $request->input('columnas') ? explode(',', $request->input('columnas')) : ['*'];
        // $results = $this->connectService->ejecutarConsultaDinamica($ip, $database, $tabla, $columnas);  
        // return $results;
        if ($request->ajax()){
            // $columnas = $request->input('columnas') ? explode(',', $request->input('columnas')) : ['*'];
            // $results = $this->connectService->ejecutarConsultaDinamica($ip, $database, $tabla, $columnas);   
            // $facturas = InvoiceSfrt::paginate(10);
            $facturas = Invoice::query(); // Esto te permitirá usar la paginación de DataTables

            // return response()->json($results);
            // $assigned = AssingRegister::with(['register','operator','unit','status'])->get();
            return DataTables::of($facturas)
                // ->addIndexColumn()
                ->addColumn('sfrtFolioInvoice', function($result){
                    return $result->serie.$result->folio;
                })
                ->addColumn('sfrtCustomer', function($result){
                    return $result->customer->nombre;
                })
            ->make(true);
            // ->toJson();
            // ->make(true);
         }

        return view('invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DatabaseService;
use Illuminate\Support\Facades\DB;
use App\Models\Sfrt\Invoice;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Illuminate\Support\Str;

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
        $ip = '192.168.193.29\NATIONALSOFT';
        $database = 'softrestaurant10';
        Config::set('database.connections.sqlsrv.host', $ip);
        Config::set('database.connections.sqlsrv.database', $database);
        DB::purge('sqlsrv');
        //InvoiceSfrt::setDynamicConnection('sqlsrv');
        $mes = Carbon::now()->month; // Obtiene el mes actual
        $mes = Carbon::createFromFormat('Y-m', '2024-11')->month; // Mes de noviembre de 2024

        // $columnas = $request->input('columnas') ? explode(',', $request->input('columnas')) : ['*'];
        // $results = $this->connectService->ejecutarConsultaDinamica($ip, $database, $tabla, $columnas);  
        // return $results;
        if ($request->ajax()){
            // $columnas = $request->input('columnas') ? explode(',', $request->input('columnas')) : ['*'];
            // $results = $this->connectService->ejecutarConsultaDinamica($ip, $database, $tabla, $columnas);   
            // $facturas = InvoiceSfrt::paginate(10);
            $facturas = Invoice::query()->sinCancelados()->whereMonth('fecha', $mes) ;
            // return response()->json($results);
            // $assigned = AssingRegister::with(['register','operator','unit','status'])->get();
            return DataTables::of($facturas)
                // ->addIndexColumn()
                ->addColumn('sfrtNotaDate', function($result){
                    // return $result->nota;
                    return '
                    <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">'. $result->nota .'</a></h5>
                    <p class="text-muted mb-0">'. $result->cheques->fecha->format('d-m-Y') .'</p>';
                })
                // ->addColumn('sfrtFolioInvoice', function($result){
                //     return $result->serie.$result->folio;
                // })
                ->addColumn('sfrtCustomer', function($result){
                    return '<h5 class="text-truncate font-size-14 mb-1" data-toggle="tooltip" data-placement="top" title="'.$result->customer->nombre.'"><a href="javascript: void(0);" class="text-dark">'.Str::limit($result->customer->nombre,15, '...').'</a></h5>
                            <span class="badge badge-soft-primary" data-toggle="tooltip" data-placement="top" title="'.$result->customer->email.'">'.Str::limit($result->customer->email,15, '...') .'</span>';
                })
                ->addColumn('sfrtCustomerEmail', function($result){
                    return '<span class="badge badge-soft-primary">'.Str::limit($result->customer->email,15, '...') .'</span>';
                })
                ->editColumn('formapago', function($result){
                    return $result->FormaDePagoTexto;
                })
                ->editColumn('idmetodopago_SAT', function($result){
                    $opciones = '';
                    if ($result->idmetodopago_SAT == 'PUE') {
                        $opciones .= '<span class="badge bg-success">' . $result->idmetodopago_SAT . '</span>';
                    } else {
                        $opciones .=  '<span class="badge bg-warning">' . $result->idmetodopago_SAT . '</span>';
                    }
                    return $opciones;

                })
                ->editColumn('fecha', function($result){
                    return '
                    <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">'.$result->serie.$result->folio.'</a></h5>
                    <p class="text-muted mb-0">'. $result->fecha->format('d-m-Y') .'</p>';
                })
                ->rawColumns(['sfrtNotaDate','sfrtCustomer','sfrtCustomerEmail','idmetodopago_SAT','fecha'])
                ->make(true);
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DatabaseService;
use DB;
use App\Models\InvoiceSfrt;
use Yajra\DataTables\Facades\DataTables;

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
        //  return $facturas = InvoiceSfrt::all();
        //  return $facturas = DB::connection('sqlsrv')->table('facturas')->get(); // Uses SQL Server

        $ip = '192.168.193.73';
        $database = 'softrestaurant11';
        $tabla = 'facturas';
        // $columnas = $request->input('columnas') ? explode(',', $request->input('columnas')) : ['*'];
        // $results = $this->connectService->ejecutarConsultaDinamica($ip, $database, $tabla, $columnas);  
        // return $results;
        if ($request->ajax()){
            $columnas = $request->input('columnas') ? explode(',', $request->input('columnas')) : ['*'];
            $results = $this->connectService->ejecutarConsultaDinamica($ip, $database, $tabla, $columnas);   
            // return response()->json($results);
            // $assigned = AssingRegister::with(['register','operator','unit','status'])->get();
            return DataTables::of($results)
                ->addIndexColumn()
            // ->addColumn('sfolio', function($result){
            //     return $result['nota'];
            // })
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

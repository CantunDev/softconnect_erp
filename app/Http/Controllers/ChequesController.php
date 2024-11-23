<?php

namespace App\Http\Controllers;

use App\Services\DatabaseService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ChequesController extends Controller
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
        $ip = '192.168.193.73';
        $database = 'softrestaurant11';
        $tabla = 'cheques';
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
            ->addColumn('sfolio', function($result){
                $result = (array) $result; // Convertir en array
                return $result['seriefolio'] . $result['folio'];
            })
            ->rawColumns(['sfolio'])
            ->make(true);
            // ->toJson();
            // ->make(true);
         }
        return view('cheques.index');

       
    }

    public function get(Request $request, $ip, $database,$tabla)
    {
            $ip = '192.168.193.73';
            $database = 'softrestaurant11';
            $tabla = 'cheques';
            
            $columnas = $request->input('columnas') ? explode(',', $request->input('columnas')) : ['*'];
            $results = $this->connectService->ejecutarConsultaDinamica($ip, $database, $tabla, $columnas);   
            return response()->json($results);
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

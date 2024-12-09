<?php

namespace App\Http\Controllers;

use App\Models\Sfrt\AccountingAccount;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ip = '192.168.193.226\NATIONALSOFT';
        $database = 'softrestaurant10';
        Config::set('database.connections.sqlsrv.host', $ip);
        Config::set('database.connections.sqlsrv.database', $database);
        DB::purge('sqlsrv');
        $mes = Carbon::createFromFormat('Y-m', '2024-11')->month; // Mes de noviembre de 2024

        if ($request->ajax()){
            $accountings = AccountingAccount::query();
            return DataTables::of($accountings)
                ->addIndexColumn()
                 ->editColumn('tipo', function($result){
                    $status = '';
                        if ($result->tipo == 1) {
                            $status .= '<div class="badge rounded-pill font-size-12 badge-soft-info"> DEBE </div>';
                        }else{
                            $status .= '<div class="badge rounded-pill font-size-12 badge-soft-dark"> HABER </div>';
                        }
                    return $status;

                    })
                 ->addColumn('status', function($result){
                    $status = '';
                        if ($result->usarenoperacion == 1) {
                            $status .= '<div class="badge font-size-12 badge-soft-success"> TODOS </div>';
                        }
                        elseif($result->usarenoperacion == 2) {
                            $status .= '<div class="badge font-size-12 badge-soft-primary"> COMPRAS </div>';
                        }
                        elseif($result->usarenoperacion == 3) {
                            $status .= '<div class="badge font-size-12 badge-soft-primary"> GASTOS </div>';
                        }
                        else{
                            $status .= '<div class="badge font-size-12 badge-soft-danger"> SUSPENDIDO </div>';
                        }
                    return $status;

                    })
                ->addColumn('action', function ($result){
                    $opciones = '';
                        // if (Auth::user()->can('read_operators')){
                            // $opciones .= '<button type="button"  onclick="btnInfo('.$result->id.')" class="btn btn-sm action-icon icon-dual-blue"><i class="mdi mdi-dots-horizontal"></i></button>';
                        // }
                        // if (Auth::user()->can('update_operators')){
                            $opciones .= '<a href="'.route('restaurants.edit', $result->idcuentacontable).'" class="btn btn-sm text-warning action-icon icon-dual-warning p-1"><i class="mdi mdi-pencil font-size-18"></i></a>';
                            $opciones .= '<button type="button" onclick="btnRestore(\''.$result->idcuentacontable.'\')" class="btn btn-sm text-primary action-icon icon-dual-secondary p-1"><i class="mdi mdi-restore font-size-18"></i></button>';
                        // }
                        // if (Auth::user()->can('delete_operators')){
                            $opciones .= '<button type="button" onclick="btnSuspend(\''.$result->idcuentacontable.'\')" class="btn btn-sm text-secondary action-icon icon-dual-secondary p-1"><i class="mdi mdi-power-standby font-size-18"></i></button>';

                            // $opciones .= '<button type="button" onclick="btnDelete('.$result->id.')" class="btn btn-sm text-secondary action-icon icon-dual-secondary btnDelete p-1"><i class="mdi mdi-delete-empty font-size-18"></i></button>';
                            
                        // }
                    return $opciones;
                })
                ->rawColumns(['tipo','status','action'])
                ->make(true);
         }
        return view('payment_methods.index');
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
    public function update(Request $request, $id)
    {        
    }


    public function suspend(Request $request, $id)
    {
        $ip = '192.168.193.226\NATIONALSOFT';
        $database = 'softrestaurant10';
        Config::set('database.connections.sqlsrv.host', $ip);
        Config::set('database.connections.sqlsrv.database', $database);
        DB::purge('sqlsrv');
        $account = AccountingAccount::findOrFail($id);
        $account->usarenoperacion = 4;
        $account->save();
        if ($account){
             $success = true;
             $message = "Actualizada Correctamente";
         } else {
             $success = true;
            $message = "No se ha podido actualizar";
            }
            return response()->json([
             'success' => $success,
             'message' => $message
         ], 200);
    }

    public function restore(Request $request, $id)
    {
        $ip = '192.168.193.226\NATIONALSOFT';
        $database = 'softrestaurant10';
        Config::set('database.connections.sqlsrv.host', $ip);
        Config::set('database.connections.sqlsrv.database', $database);
        DB::purge('sqlsrv');
        $account = AccountingAccount::findOrFail($id);
        $account->usarenoperacion = 1;
        $account->save();
        if ($account){
             $success = true;
             $message = "Actualizada Correctamente";
         } else {
             $success = true;
            $message = "No se ha podido actualizar";
            }
            return response()->json([
             'success' => $success,
             'message' => $message
         ], 200);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $idcuentacontable)
    {
    }
}

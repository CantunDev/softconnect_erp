<?php

namespace App\Http\Controllers;

use App\Models\Sfrt\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class ProvidersController extends Controller
{

    public function index(Request $request)
    {
        /*INDEX PARA PROVEEDORES */
        // $providers = Provider::all();
        $ip = '192.168.193.226\NATIONALSOFT';
        $database = 'softrestaurant10';
        Config::set('database.connections.sqlsrv.host', $ip);
        Config::set('database.connections.sqlsrv.database', $database);
        DB::purge('sqlsrv');
        $mes = Carbon::createFromFormat('Y-m', '2024-11')->month; // Mes de noviembre de 2024

        if ($request->ajax()){
            $providers = Provider::query();
            return DataTables::of($providers)
                ->addIndexColumn()
                ->addColumn('name', function($result){
                    return $name = '
                    <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">'.$result->nombre.'</a></h5>
                    <p class="text-muted mb-0">'.$result->razonsocial.'</p>';
                
                })
                ->addColumn('action', function ($result){
                    $opciones = '';
                        // if (Auth::user()->can('read_operators')){
                            $opciones .= '<button type="button"  onclick="btnInfo('.$result->id.')" class="btn btn-sm text-info action-icon icon-dual-blue"><i class="mdi mdi-information-outline font-size-18"></i></button>';
                        // }
                        // if (Auth::user()->can('update_operators')){
                            // $opciones .= '<a href="'.route('restaurants.edit', $result->id).'" class="btn btn-sm text-warning action-icon icon-dual-warning p-1"><i class="mdi mdi-pencil font-size-18"></i></a>';
                            
                            // $opciones .= '<a href="'.route('restaurants.edit', $result->id).'" class="btn btn-sm text-primary action-icon icon-dual-warning p-1"><i class="mdi mdi-restore font-size-18"></i></a>';
                        // }
                        // if (Auth::user()->can('delete_operators')){
                            // $opciones .= '<button type="button" onclick="btnDelete('.$result->id.')" class="btn btn-sm text-secondary action-icon icon-dual-secondary btnDelete p-1"><i class="mdi mdi-delete-empty font-size-18"></i></button>';
                            
                        // }
                    return $opciones;
                })
                // ->addColumn('action', function($result) {
                //     $buttons = [
                //         'view' => [
                //             'title' => 'View',
                //             'class' => 'btn-outline-primary',
                //             'icon' => 'mdi-eye-outline',
                //             'href' => '#'
                //         ],
                //         'edit' => [
                //             'title' => 'Edit',
                //             'class' => 'btn-outline-info',
                //             'icon' => 'mdi mdi-pencil',
                //             'href' => '#'
                //         ],
                //         'delete' => [
                //             'title' => 'Delete',
                //             'class' => 'btn-outline-danger',
                //             'icon' => 'mdi-delete-outline',
                //             'href' => '#jobDelete',
                //             'data-toggle' => 'modal'
                //         ]
                //     ];
                //     $output = '<ul class="list-unstyled hstack gap-1 mb-0">';
                //     foreach ($buttons as $key => $button) {
                //         $output .= sprintf(
                //             '<li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="%s">
                //                 <a href="%s" class="btn btn-sm %s" %s>
                //                     <i class="mdi %s"></i>
                //                 </a>
                //             </li>',
                //             $button['title'],
                //             $button['href'],
                //             $button['class'],
                //             isset($button['data-toggle']) ? 'data-bs-toggle="' . $button['data-toggle'] . '"' : '',
                //             $button['icon']
                //         );
                //     }
                //     $output .= '</ul>';
                
                //     return $output;
                // })
                ->addColumn('purchases', function($result){
                    return $result->purchases->count();
                
                }) 
                ->addColumn('average', function($result){
                    return round( $result->purchases->avg('total'),2) ?? 0.0;
                
                }) 
                ->rawColumns(['name','action'])
                ->make(true);
         }
        return view('providers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('providers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $provider = Provider::create($request->all());
        return redirect()->route('providers.index');
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
    public function edit(Provider $provider)
    {
        return view('providers.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provider $provider)
    {
        $provider->update($request->all());
        return redirect()->route('providers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $provider = Provider::findOrFail($request->id);
        $provider->delete();
        return redirect()->route('providers.index');   
    }
}

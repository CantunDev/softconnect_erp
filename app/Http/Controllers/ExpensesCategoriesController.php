<?php

namespace App\Http\Controllers;

use App\Models\Sfrt\Provider;
use App\Models\Sfrt\SubtypeExpense;
use App\Models\Sfrt\TypeExpense;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class ExpensesCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $expenses_categories = ExpenseCategory::with('parent','children','subchildren')->where('level',1)->get();
         /*INDEX PARA PROVEEDORES */
        // $providers = Provider::all();
        $ip = '192.168.193.226\NATIONALSOFT';
        $database = 'softrestaurant10';
        Config::set('database.connections.sqlsrv.host', $ip);
        Config::set('database.connections.sqlsrv.database', $database);
        DB::purge('sqlsrv');
        $mes = Carbon::createFromFormat('Y-m', '2024-11')->month; // Mes de noviembre de 2024

        if ($request->ajax()){
            $providers = TypeExpense::query();
            return DataTables::of($providers)
                ->addIndexColumn()
                ->addColumn('subtipo', function($result){
                    if ($result->subtype?->isNotEmpty()) {
                        $items = $result->subtype->map(function ($subtype) {
                            return '<li>' . e($subtype->descripcion) . '</li>';
                        })->join('');
                        return '<ol>' . $items . '</ol>';
                    }
                    return 'Sin subtipos';
                })
                ->addColumn('action', function ($result){
                    $opciones = '';
                        // if (Auth::user()->can('read_operators')){
                            // $opciones .= '<button type="button"  onclick="btnInfo('.$result->id.')" class="btn btn-sm text-info action-icon icon-dual-blue"><i class="mdi mdi-information-outline font-size-18"></i></button>';
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
                ->rawColumns(['action', 'subtipo'])
                ->make(true);
         }
        return view('expenses_categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expenses_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  return $request->all();
        // $expenses_categories = ExpenseCategory::create($request->all());
        // return redirect()->route('expenses_categories.index');

        // $request->validate([
        //     'level' => 'required|integer|in:1,2,3',
        //     'name' => 'required|string|max:255',
        //     'parent_category' => 'required_if:level,2,3|exists:expenses_categories,id',
        //     'parent_subcategory' => 'required_if:level,3|exists:expenses_categories,id'
        // ]);

        // $category = new ExpenseCategory();
        // $category->name = $request->name;
        // $category->level = $request->level;
        $ip = '192.168.193.226\NATIONALSOFT';
        $database = 'softrestaurant10';
        Config::set('database.connections.sqlsrv.host', $ip);
        Config::set('database.connections.sqlsrv.database', $database);
        DB::purge('sqlsrv');

        if ($request->level == 1) {
            // Se registra Categoria o Tipo
            $tipogasto = TypeExpense::crearConNuevoId(['descripcion' => $request->descripcion]);
            return redirect()->route('expenses_categories.index');
        } elseif ($request->level == 2) {
            // Subcategoría
            return redirect()->route('expenses_categories.index');
        } 

        return redirect()->route('expenses_categories.index')->with('success', 'Categoría creada exitosamente.');
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

    public function getCategories()
    {
        // $categories = ExpenseCategory::where('level',1)->get(['id','name']);
        // return response()->json($categories);

        $ip = '192.168.193.226\NATIONALSOFT';
        $database = 'softrestaurant10';
        Config::set('database.connections.sqlsrv.host', $ip);
        Config::set('database.connections.sqlsrv.database', $database);
        DB::purge('sqlsrv');
        $tipogastos = TypeExpense::query()->get(['Idtipogasto','descripcion']);
        // // return response()->json($data);
        $proveedores = Provider::query()->get(['idproveedor','nombre']);

        // return response()->json($data);
        return response()->json([
            'tipogastos' => $tipogastos,
            'proveedores' => $proveedores,
        ]);
    }

    public function getSubcategories($id)
    {
        $subcategories = ExpenseCategory::where('parent_id',$id)->where('level',2)->get(['id','name']);
        return response()->json($subcategories);
    }
}

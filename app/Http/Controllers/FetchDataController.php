<?php

namespace App\Http\Controllers;

use App\Models\BusinessRestaurants;
use App\Models\ExpenseCategory;
use App\Models\Restaurant;
use App\Models\Sfrt\Provider;
use App\Models\Sfrt\TypeExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class FetchDataController extends Controller
{

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

    // public function getRestaurants($id)
    // {
    //     $restaurants = BusinessRestaurants::with('restaurants')->where('business_id',$id)->get();
    //     return response()->json($restaurants);
    // }
    public function getRestaurants(Request $request)
    {
        // Obtener los IDs de los negocios seleccionados
        $businessIds = $request->input('business_ids');

        // Validar que se hayan enviado IDs
        if (empty($businessIds)) {
            return response()->json([]);
        }

        // Obtener los restaurantes asociados a los IDs de los negocios
        $restaurants = BusinessRestaurants::with('restaurants')
            ->whereIn('business_id', $businessIds)
            ->get()
            ->pluck('restaurants') // Extraer solo los restaurantes
            ->filter(); // Eliminar valores nulos

        return response()->json($restaurants);
    }

    public function getRoles(Request $request)
    {
        if ($request->ajax()){
            $roles = Role::all();
            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('users', function($result){
                    return $result->users->count();
                })
                ->addColumn('permissions', function($result){
                    return $result->permissions->count();
                })
                ->addColumn('action', function ($result){
                    $opciones = '';
                        // if (Auth::user()->can('read_roles')){
                            // $opciones .= '<button type="button"  onclick="btnInfo('.$result->id.')" class="btn btn-sm action-icon icon-dual-blue"><i class="mdi mdi-dots-horizontal"></i></button>';
                        if (Auth::user()->can('read_roles')){
                            $opciones .= '<a href="'.route('roles_permissions.edit', $result->id).'" class="btn btn-sm text-warning action-icon icon-dual-warning p-1"><i class="mdi mdi-pencil font-size-18"></i></a>';
                        }
                         if (Auth::user()->can('delete_roles')){
                            $opciones .= '<button type="button" onclick="btnDelete('.$result->id.')" class="btn btn-sm text-secondary action-icon icon-dual-secondary btnDelete p-1"><i class="mdi mdi-delete-empty font-size-18"></i></button>';
                        }

                        // }
                    return $opciones;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getPermissions(Request $request)
    {
        if ($request->ajax()){
            $permissions = Permission::all()->groupBy('category');
            return DataTables::of($permissions)
                ->addIndexColumn()
                ->addColumn('category', function($result) {
                    $categories = $result->pluck('category')->unique()->join(',');
                    return $categories;
                }) 
                ->addColumn('permissions',function($result){
                    $html = "<ol>"; 
                    foreach ($result as $name) {
                        $html .= "<li>{$name['name']}</li>"; 
                    }
                    $html .= "</ol>"; 
                    return $html;
                })
                ->addColumn('models', function($result){
                    return 'Sin Modelo Asignado';
                })                
                ->addColumn('action', function ($result){
                    $opciones = '';
                        // if (Auth::user()->can('read_operators')){
                            // $opciones .= '<button type="button"  onclick="btnInfo('.$result->id.')" class="btn btn-sm action-icon icon-dual-blue"><i class="mdi mdi-dots-horizontal"></i></button>';
                        // }
                        // if (Auth::user()->can('update_permissions')){
                        //     $opciones .= '<a href="'.route('roles_permissions.edit', $result->keys()->first()).'" class="btn btn-sm text-warning action-icon icon-dual-warning p-1"><i class="mdi mdi-pencil font-size-18"></i></a>';
                        // }
                        // if (Auth::user()->can('delete_permissions')){
                        //     $opciones .= '<button type="button" onclick="btnDelete('.$result->keys()->first().')" class="btn btn-sm text-secondary action-icon icon-dual-secondary btnDelete p-1"><i class="mdi mdi-delete-empty font-size-18"></i></button>';
                        // }
                    return $opciones;
                })
                ->rawColumns(['category','permissions','action'])
                ->make(true);
        } 
    }
}

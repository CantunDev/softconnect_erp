<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\Restaurant;
use App\Models\Sfrt\Provider;
use App\Models\Sfrt\TypeExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

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

    public function getRestaurantes($id)
    {
        $restaurantes = Restaurant::where('business_id', $id)->get();
        return response()->json($restaurantes);
    }
}

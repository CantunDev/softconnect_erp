<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\PaymentMethod;
use App\Models\Sfrt\Provider as SfrtProvider;
use App\Models\Sfrt\TypeExpense;
use DragonCode\Contracts\LangPublisher\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('expenses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ip = '192.168.193.226\NATIONALSOFT';
        $database = 'softrestaurant10';
        Config::set('database.connections.sqlsrv.host', $ip);
        Config::set('database.connections.sqlsrv.database', $database);
        DB::purge('sqlsrv');

        $providers = SfrtProvider::all();
        $payment_method = PaymentMethod::all();
        
        $categories = TypeExpense::query();
        // $categories = ExpenseCategory::where('level',1)
        //                             ->get(["name", "id"]);
        return view('expenses.create', compact('providers','categories','payment_method'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->all();
        $expense = Expense::create($request->all());
        return view('expenses.index');
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

    public function fetchSubcategories(Request $request)
    {
        // $data['subcategories'] = ExpenseCategory::where("parent_id", $request->id)
        //                                          ->where('level',2)   
        //                                          ->get(["name", "id"]);
        // return response()->json($data);
        $ip = '192.168.193.226\NATIONALSOFT';
        $database = 'softrestaurant10';
        Config::set('database.connections.sqlsrv.host', $ip);
        Config::set('database.connections.sqlsrv.database', $database);
        DB::purge('sqlsrv');
        $tipogastos = TypeExpense::query();
        $proveedores = Provider::query();

        // return response()->json($data);
        return response()->json([
            'tipogastos' => $tipogastos,
            'proveedores' => $proveedores,
        ]);

    }

    public function fetchSubsubcategories(Request $request)
    {
        $data['subsubcategories'] = ExpenseCategory::where("parent_id", $request->id)
                                                ->where('level',3)   
                                                ->get(["name", "id"]);
        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\Provider;
use Illuminate\Http\Request;

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
        $providers = Provider::all();
        $categories = ExpenseCategory::where('level',1)
                                    ->get(["name", "id"]);
        return view('expenses.create', compact('providers','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $request->all();
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
        $data['subcategories'] = ExpenseCategory::where("parent_id", $request->id)
                                                 ->where('level',2)   
                                                 ->get(["name", "id"]);
        return response()->json($data);
    }

    public function fetchSubsubcategories(Request $request)
    {
        $data['subsubcategories'] = ExpenseCategory::where("parent_id", $request->id)
                                                ->where('level',3)   
                                                ->get(["name", "id"]);
        return response()->json($data);
    }
}

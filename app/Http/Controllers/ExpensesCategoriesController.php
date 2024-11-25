<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpensesCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses_categories = ExpenseCategory::with('parent','children','subchildren')->where('level',1)->get();
        return view('expenses_categories.index', compact('expenses_categories'));
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
        // return $request->all();
        // $expenses_categories = ExpenseCategory::create($request->all());
        // return redirect()->route('expenses_categories.index');

        // $request->validate([
        //     'level' => 'required|integer|in:1,2,3',
        //     'name' => 'required|string|max:255',
        //     'parent_category' => 'required_if:level,2,3|exists:expenses_categories,id',
        //     'parent_subcategory' => 'required_if:level,3|exists:expenses_categories,id'
        // ]);

        $category = new ExpenseCategory();
        $category->name = $request->name;
        $category->level = $request->level;

        if ($request->level == 1) {
            // Categoría principal
            $category->parent_id = null;
        } elseif ($request->level == 2) {
            // Subcategoría
            $category->parent_id = $request->parent_category;
        } elseif ($request->level == 3) {
            // Sub-subcategoría
            $category->parent_id = $request->parent_subcategory;
        }
        // return $category;
        $category->save();

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
        $categories = ExpenseCategory::where('level',1)->get(['id','name']);
        return response()->json($categories);
    }

    public function getSubcategories($id)
    {
        $subcategories = ExpenseCategory::where('parent_id',$id)->where('level',2)->get(['id','name']);
        return response()->json($subcategories);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessRestaurants;
use App\Models\Projection;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ProjectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Business $business, Restaurant $restaurants)
    {
        $user = Auth::user();
        $rest = $restaurants;
        // return $business->id;
        // if ($request->ajax()) {
            $restaurants = Restaurant::with('business')->withTrashed();

            // Filtrar según el rol del usuario
            if (!$user->hasRole('Super-Admin')) {
                if ($user->business !== 'null' && $user->business == 'rest') {
                    // Filtrar restaurantes por la empresa y que estén relacionados con el usuario
                    $restaurants->whereHas('business', function ($query) use ($business) {
                        $query->where('id', $business->id);
                    })->whereHas('users', function ($query) use ($user) {
                        $query->where('id', $user->id);
                    });
                } else {
                    // Si el usuario no tiene empresa, filtrar solo por sus restaurantes asignados
                    $restaurants->whereHas('users', function ($query) use ($user) {
                        $query->where('id', $user->id);
                    });
                }
            }
        return DataTables::of($restaurants)
            ->addIndexColumn()
            ->rawColumns([''])
            ->make(true);
        // }
        return view('projections.index', compact('restaurants'));
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
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'projected_sales' => 'required',
            'projected_tax' => 'required',
            'projected_check' => 'required',
        ]);

        Projection::create([
            'restaurant_id' => $request->restaurant_id,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
            'projected_sales' => $request->projected_sales,
            'projected_tax' => $request->projected_tax,
            'projected_check' => $request->projected_check,
            'created_at' =>  $day = Carbon::now(),
        ]);

        return response()->json(['success' => true]);
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
    public function edit($id)
    {
        $projection = Projection::where('restaurant_id', $id)->first();
        if (!$projection) {
            return response()->json(['error' => 'No encontrado'], 404);
        }

        return response()->json($projection);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'projected_sales' => 'required|numeric',
            'projected_tax' => 'required|integer',
            'projected_check' => 'required|numeric',
        ]);

        $projection = Projection::where('restaurant_id', $id)->first();

        if (!$projection) {
            return response()->json(['error' => 'No encontrado'], 404);
        }

        $projection->update([
            'projected_sales' => $request->input('projected_sales'),
            'projected_tax' => $request->input('projected_tax'),
            'projected_check' => $request->input('projected_check'),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

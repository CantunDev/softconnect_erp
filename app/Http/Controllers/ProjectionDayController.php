<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Business;
use App\Models\BusinessRestaurants;
use App\Models\Projection;
use App\Models\ProjectionDay;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectionDayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'proyecciones diarias del mes';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Business $business, Restaurant $restaurants)
    {
        $month = DateHelper::getCurrentMonth();
        $monthName = DateHelper::getCurrentMonthName();
        $year = DateHelper::getCurrentYear();
        $currentMonth = DateHelper::getCurrentMonth();
        $days = DateHelper::getDaysOfCurrentMonth();
        $projection = Projection::ForRestaurant($restaurants->id)->ForDate($year, $month)->first();
        return view('projections.monthly.create', compact('projection', 'business', 'restaurants', 'days', 'month', 'monthName', 'year', 'currentMonth'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->all();
        $restaurant = Restaurant::findOrFail($request->restaurant_id);
        $business = BusinessRestaurants::with('business')->where('restaurant_id', $request->restaurant_id)->first();
        if ($business) {
            $business = $business->business->slug;
        } else {
            $business = 'rest';
        }
        foreach ($request->projected_sales as $key => $value) {
            $data = array(
                'date' => $request->date[$key],
                'restaurant_id' => $request->restaurant_id,
                'projection_id' => $request->projection_id,
                'user_id' => Auth::user()->id,
                'projected_day_sales' => $request->projected_sales[$key],
            );
            ProjectionDay::insert($data);
        }
        return redirect()->route('business.restaurants.projections.index', ['business' => $business, 'restaurants' => $restaurant->slug])->with('success', 'Proyeccion diaria registrada');
        // return response()->json(['success' => true]);
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
    public function edit(Business $business, Restaurant $restaurants, $month)
    {
        /** Se recibe el id del restaurante para buscar el registro */
        $year = DateHelper::getCurrentYear();
        $month = DateHelper::getCurrentMonth();
        $monthName = DateHelper::getCurrentMonthName();
        $currentMonth = DateHelper::getCurrentMonth();
        $days = DateHelper::getDaysOfCurrentMonth();

        // $projections_monthly = ProjectionDay::ForRestaurant($restaurants->id)
        //     ->ForDate($year, $month)
        //     ->get();

        $projections_monthly = [];
        $projection = Projection::ForRestaurant($restaurants->id)->ForDate($year, $month)->first();

         foreach ($days as $dayNumber => $short_day) {
         $projectionDay = ProjectionDay::ForRestaurant($restaurants->id)
                            ->ForDate($year, $month)->get();
        $projections_monthly = $projectionDay ? $projectionDay : 0;
        }
        return view('projections.monthly.edit', compact('projections_monthly', 'projection', 'business','restaurants', 'days', 'month', 'monthName', 'year', 'currentMonth'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Business $business, Restaurant $restaurants, Request $request, string $id)
    {
        // return $request->all();
        $year = DateHelper::getCurrentYear();
        $month = DateHelper::getCurrentMonth();
        // $restaurant = Restaurant::findOrFail($request->restaurant_id);
        // $year = $request->year;
        $projections = ProjectionDay::ForRestaurant($restaurants->id)
            ->ForDate($year, $month)
            ->get();
        // $business = BusinessRestaurants::with(['business', 'restaurants'])->where('restaurant_id', $request->restaurant_id)->first();
        // if ($business) {
        //     $business = $business->business->slug;
        // } else {
        //     $business = 'rest';
        // }
        foreach ($request->projected_sales as $key => $value) {
            $data = array(
                'projected_day_sales' => $request->projected_sales[$key],
            );
            $projections[$key]->update($data);
        }
        return redirect()->route('business.projections.index', ['business' => $business->slug])->with('update', 'Requisición Actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

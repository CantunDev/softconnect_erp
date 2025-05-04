<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Business;
use App\Models\BusinessRestaurants;
use App\Models\Projection;
use App\Models\ProjectionDay;
use App\Models\Restaurant;
use App\Models\Sfrt\Cheques;
use App\Services\DynamicConnectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        return view('projections.monthly.edit', compact('projections_monthly', 'projection', 'business', 'restaurants', 'days', 'month', 'monthName', 'year', 'currentMonth'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Business $business, Restaurant $restaurants, Request $request, string $id)
    {
        // return $request->all();
        $year = DateHelper::getCurrentYear();
        $month = DateHelper::getCurrentMonth();

        // Obtener proyecciones y convertirlas en un array indexado por fecha completa (YYYY-MM-DD)
        $projections = ProjectionDay::ForRestaurant($restaurants->id)
            ->ForDate($year, $month)
            ->get()
            ->keyBy(function ($item) {
                return $item->date; // Asumiendo que hay una columna 'date' con formato YYYY-MM-DD
            });
         
        foreach ($request->date as $index => $date) {
            $projectedSales = $request->projected_sales[$index] ?? null;

            if ($projectedSales && isset($projections[$date])) {
                $projections[$date]->update([
                    'projected_day_sales' => $projectedSales,
                ]);
            }
        }

        return redirect()
            ->route('business.projections.index', ['business' => $business->slug])
            ->with('update', 'Proyecciones actualizadas correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function sales_get(Business $business, Restaurant $restaurants, DynamicConnectionService $connectionService)
    {
        $year = DateHelper::getCurrentYear();
        $month = DateHelper::getCurrentMonth();
        $monthName = DateHelper::getCurrentMonthName();
        $currentMonth = DateHelper::getCurrentMonth();
        $days = DateHelper::getDaysOfCurrentMonth();
        $projections_monthly = [];
        $projection = Projection::ForRestaurant($restaurants->id)->ForDate($year, $month)->first();

        foreach ($days as $dayNumber => $short_day) {
            $projectionDay = ProjectionDay::ForRestaurant($restaurants->id)
                ->ForDate($year, $month)->get();
            $projections_monthly = $projectionDay ? $projectionDay : 0;
        }

        $connectionResult = $connectionService->configureConnection($restaurants);

        if ($connectionResult['success']) {
            $connection = $connectionResult['connection'];
            // Obtener ventas agrupadas por fecha
            $salesData = $connection->table('cheques')->whereMonth('fecha', $month)
                ->whereYear('fecha', $year)
                ->where('cancelado', false)
                ->selectRaw("CONVERT(VARCHAR, fecha, 23) as date, 
                    SUM(total) as total_sales,
                    SUM(nopersonas) as total_personas")
                ->groupBy(DB::raw("CONVERT(VARCHAR, fecha, 23)"))
                ->orderBy('date')
                ->get()
                ->keyBy('date');

            // Generar estructura para todos los días del mes
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $sales = [];

            foreach ($days as $i => $dayInfo) {
                $date = $dayInfo['full_date'];
                $sales[] = [
                    'date' => $date,
                    'total_sales' => $salesData[$date]->total_sales ?? 0,
                    'total_personas' => $salesData[$date]->total_personas ?? 0,
                    'day_number' => $i + 1
                ];
            }
        } else {
            $sales = array_map(function ($dayInfo) {
                return [
                    'date' => $dayInfo['full_date'],
                    'total_sales' => 0,
                    'total_personas' => 0,
                    'day_number' => $dayInfo['day_number']
                ];
            }, $days);
        }
        return view('projections.monthly.sales', compact(
            'projections_monthly',
            'projection',
            'business',
            'restaurants',
            'days',
            'month',
            'monthName',
            'year',
            'currentMonth',
            'sales'
        ));
    }

    public function sales_update(Business $business, Restaurant $restaurants, Request $request)
    {
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
        foreach ($request->actual_day_sales as $key => $value) {
            $data = array(
                'actual_day_sales' => $request->actual_day_sales[$key],
                'actual_day_tax' => $request->actual_day_tax[$key],
                'actual_day_check' => $request->actual_day_check[$key],
            );
            $projections[$key]->update($data);
        }
        return redirect()->route('business.projections.index', ['business' => $business->slug])->with('update', 'Requisición Actualizada');
    }
}

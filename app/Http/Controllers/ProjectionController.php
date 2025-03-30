<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Business;
use App\Models\BusinessRestaurants;
use App\Models\Projection;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\GlobalState\Restorer;
use Yajra\DataTables\Facades\DataTables;

class ProjectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Business $business, Restaurant $restaurants)
    {
        $user = Auth::user();
        // return $this->getFilteredRoute($user);

        if ($request->ajax()) {
            $restaurants = $this->getFilteredRoute($user);

            
            return DataTables::of($restaurants)
                ->addIndexColumn()
                ->addColumn('name', function ($result) {
                    return $name = '
                    <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">' . $result->name . '</a></h5>
                    <p class="text-muted mb-0">' . $result->business->name . '</p>';
                })
                ->addColumn('projections', function ($result) {
                    $year = DateHelper::getCurrentYear();
                    // return '<span class="price">'.$result->getColumnSumByYear('projected_sales', $year, $result->id).' </span>';
                    $value = $result->getColumnSumByYear('projected_sales', $year, $result->id);
                    return '<span class="price">' . (is_numeric($value) ? $value : '0') . '</span>';
                })
                ->addColumn('profit', function ($result) {
                    $year = DateHelper::getCurrentYear();
                    return '<span class="price">' . $result->getColumnSumByYear('projected_profit', $year, $result->id) . ' </span>';
                })
                ->addColumn('tax', function ($result) {
                    $year = DateHelper::getCurrentYear();
                    return '<span class="">' . $result->getColumnSumByYear('projected_tax', $year, $result->id) . ' </span>';
                })
                ->addColumn('check', function ($result) {
                    $year = DateHelper::getCurrentYear();
                    return '<span class="price">' . $result->getColumnSumByYear('projected_check', $year, $result->id) . ' </span>';
                })
                ->addColumn('action', function ($result) {
                    $opciones = '';
                    if ($result->projections->isEmpty()) {
                        $opciones .= '<a href="' . route('business.restaurants.projections.create', [
                            'business' => $result->business->slug,
                            'restaurants' => $result->slug,
                        ]) . '" class="btn btn-sm text-primary action-icon icon-dual-warning p-1">
                            <i class="mdi mdi-chart-timeline-variant-shimmer font-size-18"></i>
                        </a>';
                    } else {
                        $opciones .= '<a href="' . route('business.restaurants.projections.edit', [
                            'business' => $result->business->slug,
                            'restaurants' => $result->slug,
                            'projection' => $result->id
                        ]) . '" class="btn btn-sm text-warning action-icon icon-dual-warning p-1">
                            <i class="mdi mdi-chart-timeline-variant-shimmer font-size-18"></i>
                        </a>';
                    }

                    return $opciones;
                })
                ->rawColumns(['name', 'projections', 'profit', 'tax', 'check', 'action'])
                ->make(true);
        }
        
        return view('projections.index', compact('restaurants', 'business'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Business $business, Restaurant $restaurants)
    {
        $months = DateHelper::getMonthsOfYear();
        $year = DateHelper::getCurrentYear();
        $currentMonth = DateHelper::getCurrentMonth();

        return view('projections.create', compact('restaurants', 'months', 'year', 'currentMonth'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $restaurant = Restaurant::findOrFail($request->restaurant_id);
        $business = BusinessRestaurants::with('business')->where('restaurant_id', $request->restaurant_id)->first();
        if ($business) {
            $business = $business->business->slug;
        } else {
            $business = 'rest';
        }
        foreach ($request->projected_sales as $key => $value) {
            $data = array(
                'restaurant_id' => $request->restaurant_id,
                'year' => $request->year,
                'month' => $request->month[$key],
                'projected_sales' => $request->projected_sales[$key],
                'projected_costs' => $request->projected_costs[$key],
                'projected_profit' => $request->projected_profit[$key],
                'projected_tax' => $request->projected_tax[$key],
                'projected_check' => $request->projected_check[$key],
                'created_at' => now(),
                'updated_at' => now(),
            );
            $projections = Projection::insert($data);
        }
        return redirect()->route('business.restaurants.projections.index', ['business' => $business, 'restaurants' => $restaurant->slug])->with('success', 'Requisición almacenada');
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
    public function edit(Business $business, Restaurant $restaurants, $projections)
    {
        $months = DateHelper::getMonthsOfYear();
        $year = DateHelper::getCurrentYear();
        $currentMonth = DateHelper::getCurrentMonth();

        $projections = Projection::where('restaurant_id', $restaurants->id)
            ->where('year', $year)
            ->get();

        $projectionsByMonth = [];
        foreach ($months as $monthNumber => $monthName) {
            $projection = $projections->firstWhere('month', $monthNumber);
            $projectionsByMonth[$monthNumber] = $projection ? $projection : 0;
        }
        return view('projections.edit', compact('projections', 'projectionsByMonth', 'restaurants', 'currentMonth', 'months', 'year'));

        // return response()->json($projection);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Business $business, Restaurant $restaurant, Request $request)
    {
        $restaurant = Restaurant::findOrFail($request->restaurant_id);
        $year = $request->year;
        $projections = Projection::where('restaurant_id', $restaurant->id)
            ->where('year', $year)
            ->get();
        $business = BusinessRestaurants::with(['business', 'restaurants'])->where('restaurant_id', $request->restaurant_id)->first();
        if ($business) {
            $business = $business->business->slug;
        } else {
            $business = 'rest';
        }
        foreach ($request->projected_sales as $key => $value) {
            $data = array(
                'restaurant_id' => $request->restaurant_id,
                'year' => $year,
                'month' => $request->month[$key],
                'projected_sales' => $request->projected_sales[$key],
                'projected_costs' => $request->projected_costs[$key],
                'projected_profit' => $request->projected_profit[$key],
                'projected_tax' => $request->projected_tax[$key],
                'projected_check' => $request->projected_check[$key],
            );
            $projections[$key]->update($data);
        }
        return redirect()->route('business.restaurants.projections.index', ['business' => $business, 'restaurants' => $restaurant->slug])->with('update', 'Requisición Actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getFilteredRoute($user)
    {
        // Obtener el slug de la empresa y el restaurante desde la URL
        $businessSlug = request()->segment(1); // Primer segmento de la URL (ej: "corazon-contento")
        $restaurantSlug = request()->segment(2); // Segundo segmento de la URL (ej: "perro-cafe")

        // Iniciar la consulta de restaurantes
        $restaurants = Restaurant::with('projections');

        // Si el usuario no es Super-Admin, aplicar filtros según sus permisos
        if (!$user->hasRole('Super-Admin')) {
            if ($user->business !== 'null' && $user->business == 'rest') {
                // Filtrar restaurantes por la empresa y que estén relacionados con el usuario
                $restaurants->whereHas('business', function ($query) use ($businessSlug) {
                    $query->where('slug', $businessSlug);
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

        // Si la URL contiene un restaurante, filtrar por el slug del restaurante
        if ($restaurantSlug && $restaurantSlug !== 'projections') {
            $restaurants->where('slug', $restaurantSlug);
        }

        // Si la URL solo contiene la empresa, filtrar por el slug de la empresa
        if ($businessSlug && !$restaurantSlug) {
            $restaurants->whereHas('business', function ($query) use ($businessSlug) {
                $query->where('slug', $businessSlug);
            });
        }

        // Obtener los restaurantes filtrados
        return $restaurants->get();
    }
}

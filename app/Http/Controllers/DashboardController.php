<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request, ?Business $business = null, ?Restaurant $restaurant = null)
{
    $user = Auth::user();

    // Si viene empresa en la ruta
    if ($business) {
        return $this->businessDashboard($business);
    }

    // Si viene restaurante en la ruta
    if ($restaurant) {
        return $this->restaurantDashboard($restaurant);
    }

    // Super admin
    if ($user->hasRole('Super-Admin')) {
        return $this->superAdminDashboard($request, $business);
    }

    // Si el usuario tiene restaurantes asignados
    if ($user->restaurants()->exists()) {
        $restaurant = $user->restaurants()->first();
        return $this->restaurantDashboard($restaurant);
    }

    // Si tiene empresas asignadas
    if ($user->businesses()->exists()) {
        $business = $user->businesses()->first();
        return $this->businessDashboard($business);
    }

    }
    protected function superAdminDashboard(Request $request, ?Business $business = null)
    {
        $user = Auth::user();

        $restaurants = $this->getFilteredRoute($user, $business);

        return view('dashboards.superadmin', compact('restaurants'));
    }

    protected function businessDashboard(Business $business)
    {
        $user = Auth::user();

        $restaurants = $user->restaurants()
            ->whereHas('business', function ($query) use ($business) {
                $query->where('id', $business->id);
            })
            ->get();

        return view('dashboards.business', [
            'restaurants' => $restaurants
        ]);
    }

    protected function restaurantDashboard(Restaurant $restaurants)
    {
        // Convertimos a colección para evitar errores con count() o foreach
        $restaurants = collect([$restaurants]);

        return view('dashboards.restaurant', [
            'restaurants' => $restaurants
        ]);
    }

    public function getFilteredRoute($user, ?Business $business = null)
    {
        $businessSlug = $business?->slug;
        $restaurantSlug = request()->segment(2);

        $restaurants = Restaurant::with(['projections', 'business', 'projections_days']);

        // Caso especial restaurantes sin business
        if ($businessSlug === 'rest') {

            if ($restaurantSlug) {
                $restaurants->whereNull('business_id')
                    ->where('slug', $restaurantSlug);
            } else {
                $restaurants->whereNull('business_id');
            }

            if (!$user->hasRole('Super-Admin')) {
                $restaurants->whereHas('users', function ($query) use ($user) {
                    $query->where('id', $user->id);
                });
            }

            return $restaurants->get();
        }

        if (!$user->hasRole('Super-Admin')) {
            $restaurants->whereHas('users', function ($query) use ($user) {
                $query->where('id', $user->id);
            });
        }

        if ($restaurantSlug && $restaurantSlug !== 'projections') {
            $restaurants->where('slug', $restaurantSlug);
        } elseif ($businessSlug) {
            $restaurants->whereHas('business', function ($query) use ($businessSlug) {
                $query->where('slug', $businessSlug);
            });
        }

        return $restaurants->get();
    }
}
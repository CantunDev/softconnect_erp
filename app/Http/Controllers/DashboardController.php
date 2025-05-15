<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Business;
use App\Models\ProjectionDay;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\DynamicConnectionService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // protected $connectionService;

    // public function __construct(DynamicConnectionService $connectionService)
    // {
    //     $this->connectionService = $connectionService;
    // }

    public function index(Request $request, Business $business, Restaurant $restaurants)
    {
        $user = Auth::user();
        if ($user->hasRole('Super-Admin')) {
            return $this->superAdminDashboard($request, $business, $restaurants);
        }
        if ($user->business->isNotEmpty()) {
            return $this->businessDashboard();
        }
        if ($user->restaurants->isNotEmpty()) {
             return $this->restaurantDashboard();
        }
        return view('dashboards.default');
    }

    protected function superAdminDashboard(Request $request, Business $business, Restaurant $restaurants)
    {
        $user = Auth::user();
        $restaurants = $this->getFilteredRoute($user, $business);

        return view('dashboards.superadmin',compact('restaurants'));
    }

    protected function businessDashboard()
    {
        $user = Auth::user();
        $restaurants = $user->restaurants()
                    ->whereHas('business',function($query) use ($user){
                        $query->whereIn('business_id', $user->business()->pluck('id'));
                    })->get();

        
        return view('dashboards.business', ['restaurants' => $restaurants]);
    }

    protected function restaurantDashboard( Request $request, Business $business, Restaurant $restaurants)
    {
        $restaurants = Auth::user()->restaurants;

        return view('dashboards.restaurant',['restaurants' => $restaurants,]); 
    }

    public function getFilteredRoute($user, $business = null)
    {   
        $businessSlug = $business->slug;
        $restaurantSlug = request()->segment(2);
    
        $restaurants = Restaurant::with(['projections', 'business', 'projections_days']);
    
        // Special case: restaurant without business (segment 1 = "rest")
        if ($businessSlug === 'rest') {
            if ($restaurantSlug) {
                // Show specific restaurant without business
                $restaurants->whereNull('business_id')
                    ->where('slug', $restaurantSlug);
            } else {
                // Show all restaurants without business
                $restaurants->whereNull('business_id');
            }
    
            // Apply permission filters if not Super-Admin
            if (!$user->hasRole('Super-Admin')) {
                $restaurants->whereHas('users', function ($query) use ($user) {
                    $query->where('id', $user->id);
                });
            }
    
            return $restaurants->get();
        }
    
        // For non-Super-Admin users, apply permission filters
        if (!$user->hasRole('Super-Admin')) {
            $restaurants->whereHas('users', function ($query) use ($user) {
                $query->where('id', $user->id);
            });
        }
    
        // If there's segment 2 (restaurantSlug), filter by specific restaurant
        if ($restaurantSlug && $restaurantSlug !== 'projections') {
            $restaurants->where('slug', $restaurantSlug);
        }
        // If only segment 1 (businessSlug), filter by business
        elseif ($businessSlug) {
            $restaurants->whereHas('business', function ($query) use ($businessSlug) {
                $query->where('slug', $businessSlug);
            });
        }
    
        return $restaurants->get();
    }
}

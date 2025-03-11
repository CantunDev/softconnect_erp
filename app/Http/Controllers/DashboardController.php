<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\DynamicConnectionService;

class DashboardController extends Controller
{
    protected $connectionService;

    public function __construct(DynamicConnectionService $connectionService)
    {
        $this->connectionService = $connectionService;
    }

    public function index()
    {
        // return view('dashboard');

        $user = Auth::user();
        if ($user->hasRole('Super-Admin')) {
            return $this->superAdminDashboard();
        }
        if ($user->business->isNotEmpty()) {
            return $this->businessDashboard();
        }
        if ($user->restaurants->isNotEmpty()) {
             return $this->restaurantDashboard();
        }
        return view('dashboards.default');
    }

    protected function superAdminDashboard()
    {
        return view('dashboards.superadmin');
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

    protected function restaurantDashboard()
    {
        $restaurants = Auth::user()->restaurants;

        return view('dashboards.restaurant',['restaurants' => $restaurants,]); 
    }
}

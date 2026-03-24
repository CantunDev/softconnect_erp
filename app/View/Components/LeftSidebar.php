<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use App\Models\Business;
use App\Models\BusinessRestaurants;

class LeftSidebar extends Component
{
    public $business;
    public $restaurantsWithBusiness;
    public $restaurantsWithoutBusiness;

    public function __construct()
    {
        $user = Auth::user();

        if ($user->hasRole('Super-Admin')) {
            $this->business                 = Business::with('restaurants')->get();
            $this->restaurantsWithBusiness  = collect();
            $assignedRestaurantIds          = BusinessRestaurants::pluck('restaurant_id');
            $this->restaurantsWithoutBusiness = Restaurant::whereNotIn('id', $assignedRestaurantIds)->get();
        } else {
            $this->business                 = $user->business()->with('restaurants')->get();
            $this->restaurantsWithBusiness  = $user->restaurants()
                ->whereHas('business', function ($query) use ($user) {
                    $query->whereIn('business_id', $user->business()->pluck('id'));
                })->get();
            $assignedRestaurantIds          = BusinessRestaurants::pluck('restaurant_id');
            $this->restaurantsWithoutBusiness = $user->restaurants()
                ->whereNotIn('id', $assignedRestaurantIds)->get();
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.left-sidebar.index');
    }
}
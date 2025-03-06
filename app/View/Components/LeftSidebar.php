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
    public $restaurants;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $user = Auth::user();
        if ($user->hasRole('Super-Admin')) {
            $this->business = Business::with('restaurants')->get(); //Todas las empresas
            $assignedRestaurantIds = BusinessRestaurants::pluck('restaurant_id'); //Restaurantes asignados
            $this->restaurants = Restaurant::whereNotIn('id', $assignedRestaurantIds)->get(); // Todos los restaurantes sin asignar
        } else {
            // Lógica para usuarios normales
            $this->business = $user->business()->with('restaurants')->get();
            $this->restaurants = $user->restaurants()->get();
        }
        

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.left-sidebar');
    }
}

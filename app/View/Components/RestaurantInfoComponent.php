<?php

namespace App\View\Components;

use App\Helpers\DateHelper;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RestaurantInfoComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $restaurants;
    public $monthName;
    
    public function __construct($restaurants, DateHelper $date_helper)
    {
        $this->restaurants = $restaurants;
        $this->monthName = $date_helper->getCurrentMonthName();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.restaurant-info-component');
    }
}

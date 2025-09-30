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
    public $startOfMonth;
    public $endOfMonth;
    public $month;
    public $daysInMonth;
    public $daysPass;
    public $rangeMonth;
    
    public function __construct($restaurants, DateHelper $date_helper)
    {
        $this->restaurants = $restaurants;
        $this->monthName = $date_helper->getCurrentMonthName();
        $this->startOfMonth = DateHelper::getStartOfMonth();
        $this->endOfMonth = DateHelper::getEndOfMonth();
        $this->month = DateHelper::getCurrentMonthName();
        $this->daysInMonth = DateHelper::getDaysInMonth();
        $this->daysPass = DateHelper::getDaysPassed();
        $this->rangeMonth = DateHelper::getMonthProgress();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.restaurant-info-component');
    }
}

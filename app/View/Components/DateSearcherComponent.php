<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Helpers\DateHelper;

class DateSearcherComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $months;

    public function __construct()
    {
     $this->months = DateHelper::getMonthsOfYear();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.date-searcher-component');
    }
}

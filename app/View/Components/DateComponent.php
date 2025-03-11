<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Helpers\DateHelper;

class DateComponent extends Component
{   
    public $startOfMonth;
    public $endOfMonth;
    public $month;
    public $daysInMonth;
    public $daysPass;
    public $rangeMonth;
    
    public function __construct()
    {
        $this->startOfMonth = DateHelper::getStartOfMonth();
        $this->endOfMonth = DateHelper::getEndOfMonth();
        $this->month = DateHelper::getCurrentMonthName();
        $this->daysInMonth = DateHelper::getDaysInMonth();
        $this->daysPass = DateHelper::getDaysPassed();
        $this->rangeMonth = DateHelper::getMonthProgress();
    }

    public function render(): View|Closure|string
    {
        return view('components.date-component');
    }
}

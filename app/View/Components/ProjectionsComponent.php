<?php

namespace App\View\Components;

use App\Helpers\DateHelper;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ProjectionsComponent extends Component
{
    public $restaurants;
    public $currentMonthProjections;
    public $totalProjectedSales = 'Sin Información';
    public $totalActualSales = 'Sin Información';
    public $totalProjectedCosts = 'Sin Información';
    public $totalActualCosts = 'Sin Información';
    public $totalProjectedProfit = 'Sin Información';
    public $totalActualProfit = 'Sin Información';
    public $totalTax = 'Sin Información';
    public $totalCheck = 'Sin Información';
    public $averageCheck = 'Sin Información';
    public $hasData = false;

    /**
     * Create a new component instance.
     */
    public function __construct($restaurants, DateHelper $date_helper)
    {
        $this->restaurants = $restaurants;
        
        // Verificar si hay restaurantes
        if (empty($this->restaurants)) {
            return;
        }

        $currentYear = $date_helper->getCurrentYear();
        $currentMonth = $date_helper->getCurrentMonth();
        
        // Inicializamos como colección
        $this->currentMonthProjections = new Collection();
        $hasProjections = false;
        
        foreach ($this->restaurants as $restaurant) {
            if (isset($restaurant->projections) && !empty($restaurant->projections)) {
                foreach ($restaurant->projections as $projection) {
                    if ($projection->year == $currentYear && $projection->month == $currentMonth) {
                        $hasProjections = true;
                        $this->currentMonthProjections->push($projection);
                    }
                }
            }
        }

        // Si no hay proyecciones para el mes actual
        if (!$hasProjections) {
            $this->setZeroValues();
            return;
        }

        // Si llegamos aquí, hay datos válidos
        $this->hasData = true;
        $this->calculateTotals();
        $this->calculateAverages();
    }

    protected function setZeroValues(): void
    {
        $this->totalProjectedSales = 0;
        $this->totalActualSales = 0;
        $this->totalProjectedCosts = 0;
        $this->totalActualCosts = 0;
        $this->totalProjectedProfit = 0;
        $this->totalActualProfit = 0;
        $this->totalTax = 0;
        $this->totalCheck = 0;
        $this->averageCheck = 0;
    }

    protected function calculateTotals(): void
    {
        $this->currentMonthProjections->each(function ($projection) {
            $this->totalProjectedSales = (float)($this->totalProjectedSales === 'Sin Información' ? 0 : $this->totalProjectedSales) + (float)$projection->projected_sales;
            $this->totalActualSales = (float)($this->totalActualSales === 'Sin Información' ? 0 : $this->totalActualSales) + (float)$projection->actual_sales;
            $this->totalProjectedCosts = (float)($this->totalProjectedCosts === 'Sin Información' ? 0 : $this->totalProjectedCosts) + (float)$projection->projected_costs;
            $this->totalActualCosts = (float)($this->totalActualCosts === 'Sin Información' ? 0 : $this->totalActualCosts) + (float)$projection->actual_costs;
            $this->totalProjectedProfit = (float)($this->totalProjectedProfit === 'Sin Información' ? 0 : $this->totalProjectedProfit) + (float)$projection->projected_profit;
            $this->totalActualProfit = (float)($this->totalActualProfit === 'Sin Información' ? 0 : $this->totalActualProfit) + (float)$projection->actual_profit;
            $this->totalTax = (int)($this->totalTax === 'Sin Información' ? 0 : $this->totalTax) + (int)$projection->projected_tax;
            $this->totalCheck = (float)($this->totalCheck === 'Sin Información' ? 0 : $this->totalCheck) + (float)$projection->projected_check;
        });
    }

    protected function calculateAverages(): void
    {
        $this->averageCheck = $this->currentMonthProjections->avg('projected_check') ?? 0;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.projections-component');
    } 
}
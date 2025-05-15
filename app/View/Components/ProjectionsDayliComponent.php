<?php

namespace App\View\Components;

use App\Helpers\DateHelper;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProjectionsDayliComponent extends Component
{
    public $restaurants;
    public $days;
    public $restaurantDetails = [];
    public $currentYear;
    public $currentMonth;
    public $colSize;
    
    public function __construct($restaurants, DateHelper $date_helper)
    {
        $this->restaurants = $restaurants;
        $this->days = $date_helper->getDaysOfCurrentMonth();
        $this->currentYear = $date_helper->getCurrentYear();
        $this->currentMonth = $date_helper->getCurrentMonth();
        $this->colSize = $this->calculateColSize(count($restaurants));

        foreach ($restaurants as $restaurant) {
            $this->prepareDailyProjections($restaurant);
        }
    }

    /**
     * Calcula el tamaño de columna basado en el número de restaurantes.
     */
    private function calculateColSize($count)
    {
        return match (true) {
            $count === 1 => 12,
            $count === 2 => 6,
            default => 4,
        };
    }

    private function prepareDailyProjections($restaurant)
    {
        $this->restaurantDetails[$restaurant->id] = [
            'name' => $restaurant->name,
            'color_primary' => $restaurant->color_primary,
            'daily_projections' => []
        ];

        foreach ($restaurant->projections_days as $projection) {
            try {
                $projectionDate = \Carbon\Carbon::parse($projection->date);
                $dayKey = $projectionDate->format('Y-m-d');

                if (
                    $projectionDate->year == $this->currentYear &&
                    $projectionDate->month == $this->currentMonth
                ) {
                    $this->restaurantDetails[$restaurant->id]['daily_projections'][$dayKey] = [
                        'projected_day_sales' => $projection->projected_day_sales ?? 0,
                        'actual_day_sales' => $projection->actual_day_sales ?? 0,
                        'actual_day_check' => $projection->actual_day_check ?? 0,
                        'difference' => ($projection->actual_day_sales ?? 0) - ($projection->projected_day_sales ?? 0),
                        'average_check' => $projection->projected_day_check ?? 0
                    ];
                }
            } catch (\Exception $e) {
                continue; // Si hay error al parsear la fecha, saltamos esta proyección
            }
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.projections-dayli-component');
    }
}

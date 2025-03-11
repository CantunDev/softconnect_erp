<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Services\DynamicConnectionService;

class SaleInTurnComponent extends Component
{
    public $restaurants;
    public $errors = [];
    public $results = [];
    public $colSize;
    /**
     * Create a new component instance.
     */
    public function __construct($restaurants, DynamicConnectionService $connectionService)
    {
        $this->restaurants = $restaurants;
        $this->colSize = $this->calculateColSize(count($restaurants));
        foreach ($this->restaurants as $i => $restaurant) {
            $connectionResult = $connectionService->configureConnection($restaurant);

            if ($connectionResult['success']) {
                $connection = $connectionResult['connection'];

                // Obtener datos de la base de datos
                $total = $connection->table('cheques')
                    ->whereMonth('fecha', now()->month)
                    ->whereYear('fecha', now()->year)
                    ->where('pagado', true)
                    ->where('cancelado', false)
                    ->sum('total');

                $nopersonas = $connection->table('cheques')
                    ->whereMonth('fecha', now()->month)
                    ->whereYear('fecha', now()->year)
                    ->where('pagado', true)
                    ->where('cancelado', false)
                    ->sum('nopersonas');

                $chequePromedio = $nopersonas > 0 ? round(($total / $nopersonas), 2) : 0;

                // Almacenar los resultados
                $this->results[] = [
                    'name' => $restaurant->name,
                    'total' => $total,
                    'nopersonas' => $nopersonas,
                    'chequePromedio' => $chequePromedio,
                ];
            } else {
                // Almacenar el mensaje de error
                $this->errors[] = $connectionResult['message'];
            }
        }
    }

    private function calculateColSize($count)
    {
        return match (true) {
            $count === 1 => 12,
            $count === 2 => 6,
            default => 4,
        };
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sale-in-turn-component', [
            'errors' => $this->errors,
            'results' => $this->results,
        ]);
    }
}

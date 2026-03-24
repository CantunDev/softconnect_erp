<?php

namespace App\View\Components\Sales;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Services\DynamicConnectionService;
use App\Helpers\DateHelper;
use App\Models\Cheques;
use Illuminate\Support\Facades\DB;

class MonthlySalesFood extends Component
{
    /**
     * Create a new component instance.
     */
    public $restaurants;
    public $food_drink_sales;

    public function __construct($restaurants, DynamicConnectionService $connectionService, DateHelper $dateHelper)
    {
        $this->restaurants = $restaurants;
        $connectionResult = $connectionService->configureConnection($restaurants);
       if ($connectionResult['success']) {
    $connection = $connectionResult['connection'];
    $currentYear = now()->year;
    $currentMonth = now()->month;
    
    /**
     * Fecha 
     * Total alimentos 
     * Descuento alimentos
     * Porcentaje de alimentos
     * Total bebidas
     * Descuento bebidas
     * Porcentaje de bebidas
     */
    $this->food_drink_sales = Cheques::query()
        ->selectRaw('    
            CONVERT(DATE, fecha) as dia,
            SUM(totalalimentos) as total_alimentos,
            SUM(totalbebidas) as total_bebidas,
            SUM(totaldescuentoalimentos) as descuento_alimentos,
            SUM(totaldescuentobebidas) as descuento_bebidas,
            SUM(total) as total_venta
        ')
        ->whereYear('fecha', $currentYear)
        ->whereMonth('fecha', $currentMonth)
        ->where('pagado', true)
        ->where('cancelado', false)
        ->groupBy(DB::raw('CONVERT(DATE, fecha)'))
        ->orderBy('dia')
        ->get() ?? collect();
    
    // Calcular porcentajes después de obtener los datos
    foreach ($this->food_drink_sales as $sale) {
        // Porcentaje de alimentos = (total_alimentos / total_venta) * 100
        $sale->porcentaje_alimentos = $sale->total_venta > 0 
            ? round(($sale->total_alimentos * 100) / $sale->total_venta, 2) 
            : 0;
        
        // Porcentaje de bebidas = (total_bebidas / total_venta) * 100
        $sale->porcentaje_bebidas = $sale->total_venta > 0 
            ? round(($sale->total_bebidas * 100) / $sale->total_venta, 2) 
            : 0;
    }
    
} else {
    $this->food_drink_sales = collect();
    $this->cortes = collect();
    $this->errors[] = "Error en {$restaurants->name}: " . $connectionResult['message'];
}
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sales.monthly-sales-food', [
            'restaurants' => $this->restaurants,
            'food_drink_sales' => $this->food_drink_sales,
        ]);
    }
}

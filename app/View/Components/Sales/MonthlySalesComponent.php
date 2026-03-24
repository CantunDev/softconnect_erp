<?php

namespace App\View\Components\Sales;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Sfrt\Cheques;
use Illuminate\Support\Facades\DB;
use App\Services\DynamicConnectionService;
use App\Helpers\DateHelper;

class MonthlySalesComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $restaurants;
    public $cortes;
    public $errors = [];
    public function __construct($restaurants, DynamicConnectionService $connectionService, DateHelper $dateHelper)
    {
        $this->restaurants = $restaurants;
        $connectionResult = $connectionService->configureConnection($restaurants);
        if ($connectionResult['success']) {
            $connection = $connectionResult['connection'];

            $currentYear = now()->year;
            $currentMonth = now()->month;

            $this->cortes = Cheques::query()
                ->selectRaw('
                    CONVERT(DATE, fecha) as dia,
                    COUNT(*) as total_cuentas,
                    SUM(nopersonas) as total_clientes,
                    SUM(total) as total_venta,
                    SUM(totalimpuesto1) as total_iva,
                    SUM(subtotal) as total_subtotal,
                    SUM(efectivo) as total_efectivo,
                    SUM(propina) as total_propina,
                    SUM(tarjeta) as total_tarjeta,
                    SUM(descuento) as total_descuento,
                    SUM(totalalimentos) as total_alimentos,
                    SUM(totalbebidas) as total_bebidas
                ')
                ->whereYear('fecha', $currentYear)
                ->whereMonth('fecha', $currentMonth)
                ->where('pagado', true)
                ->where('cancelado', false)
                ->groupBy(DB::raw('CONVERT(DATE, fecha)'))
                ->orderBy('dia')
                ->get() ?? collect();
        }else {
            $this->cortes = collect();
            $this->errors[] = "Error en {$restaurants->name}: " . $connectionResult['message'];

        }
      
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.sales.monthly-sales-component', [
            'errors' => $this->errors,
            'cortes' => $this->cortes,
        ]);
    }
}

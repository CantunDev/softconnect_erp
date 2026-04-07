<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Projection;
use App\Models\Restaurant;
use App\Models\Sfrt\Cheques;
use Illuminate\Http\Request;
use App\Services\DynamicConnectionService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $connectionService;
    protected $currentConnection;
    protected $errors = [];
    protected $results = [];

    public function __construct(DynamicConnectionService $connectionService)
    {
        $this->connectionService = $connectionService;
    }
    
    public function index( Request $request, ?Business $business = null, ?Restaurant $restaurants = null)
    {
        $sales_monthly = collect();
        $connectionResult = $this->connectionService->configureConnection($restaurants);
        if ($connectionResult['success']) {
            $this->currentConnection = $connectionResult['connection'];
            if (is_object($this->currentConnection)) {
                $this->currentConnection = $this->currentConnection->getName();
            }
            if ($request->ajax()) {
                return $this->getSalesMonthlyDataTable($request);
            }
            $currentMonth = $request->get('month', now()->month);
            $currentYear = $request->get('year', now()->year);
            $sales_monthly = $this->getSalesMonthly($currentMonth, $currentYear);
        } else {
            $this->errors[] = "Error en {$restaurants->name}: " . $connectionResult['message'];
        }
        return view('sales.index', compact('business','restaurants'));
    }

    private function getSalesMonthly($currentMonth, $currentYear)
    {
        return Cheques::on($this->currentConnection)
            ->selectRaw('*, CAST(fecha AS DATE) as dia')
            ->where('cancelado', false)
            ->whereYear('fecha', $currentYear)
            ->whereMonth('fecha', $currentMonth)
            ->get() ?? collect();
    }

    private function getSalesMonthlyDataTable($request)
    {
        $connectionName = is_object($this->currentConnection) 
            ? $this->currentConnection->getName() 
            : $this->currentConnection;

        $query = Cheques::on($connectionName)
            ->selectRaw('
                CAST(fecha AS DATE) as fecha,
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
                SUM(totaldescuentoalimentos) as total_descuento_alimentos,
                SUM(totalbebidas) as total_bebidas,
                SUM(totaldescuentobebidas) as total_descuento_bebidas
            ')
            ->where('pagado', true)
            ->where('cancelado', false);
    
        // ── Filtro por rango de fechas ────────────────────────────────
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start        = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $end          = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            $daysInMonth  = $start->diffInDays($end) + 1;
            $daysPass     = $daysInMonth;
            $currentMonth = null;
            $currentYear  = null;
          $query->whereRaw(
            "fecha >= CONVERT(datetime, ?, 120) AND fecha <= CONVERT(datetime, ?, 120)",
            [
                $request->start_date . ' 00:00:00',
                $request->end_date   . ' 23:59:59',
            ]
        );
        } else {
            $month = $request->get('month', now()->month);
            $year  = $request->get('year',  now()->year);
            $query->whereYear('fecha',  $year)
                ->whereMonth('fecha', $month);
        }
        $query->groupBy(DB::raw('CAST(fecha AS DATE)'));

        return DataTables::of($query)
            ->orderColumn('fecha', function ($q, $order) {
                $q->orderBy('fecha', $order);
            })
            ->addIndexColumn()
             ->addColumn('fecha_formateada', function ($result) {
                return date('d/m/Y', strtotime($result->fecha));
            })
            ->make(true);
    }
}

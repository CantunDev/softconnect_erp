<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\Restaurant;
use App\Models\Sfrt\CashMovements;
use Auth;
use App\Services\DynamicConnectionService;
use Yajra\DataTables\Facades\DataTables;

class CashMovementsController extends Controller
{
    protected $connectionService;
    protected $currentConnection;
    protected $errors = [];
    protected $results = [];

    public function __construct(DynamicConnectionService $connectionService)
    {
        $this->connectionService = $connectionService;
    }

   public function index(Request $request, ?Business $business = null, ?Restaurant $restaurants = null)
    {
        $cash_movements = collect();
        $connectionResult = $this->connectionService->configureConnection($restaurants);
        if ($connectionResult['success']) {
            $this->currentConnection = $connectionResult['connection']; 
            if (is_object($this->currentConnection)) {
                $this->currentConnection = $this->currentConnection->getName();
            }
            if ($request->ajax()) {
                return $this->getCashMovementsDataTable($request);
            }
            $currentMonth = $request->get('month', now()->month);
            $currentYear = $request->get('year', now()->year);
            $cash_movements = $this->getCashMovements($currentMonth, $currentYear);
            
        } else {
            $this->errors[] = "Error en {$restaurants->name}: " . $connectionResult['message'];
        }
        return view('cash.index', compact('business', 'restaurants', 'cash_movements'));
    }

    private function getCashMovements($currentMonth, $currentYear)
    {
        return CashMovements::on($this->currentConnection)
            ->selectRaw('*, CAST(fecha AS DATE) as dia')
            ->whereYear('fecha', $currentYear)
            ->whereMonth('fecha', $currentMonth)
            ->where('cancelado', false)
            ->get() ?? collect();
    }

    /**
     * Obtener datos para DataTables vía AJAX
     */
   private function getCashMovementsDataTable($request)
{
    $connectionName = is_object($this->currentConnection) 
        ? $this->currentConnection->getName() 
        : $this->currentConnection;

    $query = CashMovements::on($connectionName)
        ->selectRaw('*, CAST(fecha AS DATE) as dia')
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

    return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('fecha_formateada', function ($result) {
            return date('d/m/Y', strtotime($result->fecha));
        })
        ->addColumn('folio_formateado', function ($result) {
            return '<span class="fw-bold">' . e($result->folio) . '</span>';
        })
        ->addColumn('importe_formateado', function ($result) {
            $clase = $result->tipo == 'Ingreso' ? 'text-success' : 'text-danger';
            return '<span class="' . $clase . ' fw-bold">$ ' . number_format($result->importe, 2) . '</span>';
        })
        ->addColumn('tipo_movto', function ($result) {
            return '<span class="badge badge-soft-' . $result->tipo_movto_badge . '">' 
                . $result->tipo_movto_label 
                . '</span>';
        })
        ->addColumn('estatus', function ($result) {
            return $result->cancelado
                ? '<span class="badge badge-soft-danger">Cancelado</span>'
                : '<span class="badge badge-soft-success">Pagado</span>';
        })
        ->addColumn('action', function ($result) {
            $id       = $result->id;
            $cancelado = $result->cancelado;

            $opciones = '
            <div class="dropdown">
                <button type="button" 
                    class="btn btn-sm btn-light" 
                    data-bs-toggle="dropdown" 
                    data-boundary="viewport"
                    aria-expanded="false">
                    <i class="mdi mdi-dots-horizontal font-size-16"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="verMovimiento(' . $id . ')">
                            <i class="mdi mdi-eye text-info me-2"></i> Ver detalles
                        </a>
                    </li>';

            if (!$cancelado) {
                $opciones .= '
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="editarMovimiento(' . $id . ')">
                            <i class="mdi mdi-pencil text-warning me-2"></i> Editar
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="cancelarMovimiento(' . $id . ')">
                            <i class="mdi mdi-cancel me-2"></i> Cancelar
                        </a>
                    </li>';
            }

            $opciones .= '</ul></div>';
            return $opciones;
        })
        ->rawColumns(['folio_formateado', 'importe_formateado', 'tipo_movto', 'estatus', 'action'])
        ->make(true);
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
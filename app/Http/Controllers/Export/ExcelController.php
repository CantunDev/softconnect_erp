<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DashboardExport;
use App\Models\Business;
use App\Models\Restaurant;
use App\Models\Projection;
use App\Models\Sfrt\Cheques;
use App\Helpers\DateHelper;
use Illuminate\Support\Facades\DB;

class ExcelController extends Controller
{
    // ── Método compartido para obtener cortes ─────────────────────
    private function getCortes(Restaurant $restaurants, Request $request): array
    {
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start       = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $end         = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            $daysInMonth = $start->diffInDays($end) + 1;
            $daysPass    = $daysInMonth;
            $currentMonth = null;
            $currentYear  = null;
        } else {
            $currentMonth = $request->input('month', DateHelper::getCurrentMonth());
            $currentYear  = $request->input('year',  DateHelper::getCurrentYear());
            $start        = \Carbon\Carbon::create($currentYear, $currentMonth, 1)->startOfDay();
            $end          = $start->copy()->endOfMonth()->endOfDay();
            $daysInMonth  = $start->daysInMonth;
            $daysPass     = min((int) now()->format('j'), $daysInMonth);
        }

        $projections = ($currentMonth && $currentYear)
            ? Projection::where('month', $currentMonth)
                ->where('year', $currentYear)
                ->where('restaurant_id', $restaurants->id)
                ->first()
            : null;

        $cortes = Cheques::query()
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
            ->whereRaw("fecha BETWEEN ? AND ?", [
                $start->format('Ymd H:i:s'),
                $end->format('Ymd H:i:s')
            ])
            ->where('pagado', true)
            ->where('cancelado', false)
            ->groupBy(DB::raw('CONVERT(DATE, fecha)'))
            ->orderBy('dia')
            ->get();

        return compact('cortes', 'projections', 'daysInMonth', 'daysPass', 'start', 'end');
    }
    public function exportExcel(?Business $business, Restaurant $restaurants, Request $request)
    {
        if ($business && $restaurants->business_id !== $business->id) abort(404);

        $data = $this->getCortes($restaurants, $request);

        $periodo = $request->filled('start_date')
            ? $request->start_date . '_' . $request->end_date
            : \Carbon\Carbon::create($request->year, $request->month)->isoFormat('MMMM_YYYY');

        return Excel::download(
            new DashboardExport($data['cortes'], $data['projections'], $restaurants),
            "reporte_{$restaurants->slug}_{$periodo}.xlsx"
        );
    }
}

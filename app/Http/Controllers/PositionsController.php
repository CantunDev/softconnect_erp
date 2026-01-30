<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Positions;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Employees;    
use App\Models\PayrollPeriods;
use App\Helpers\DateHelper;

class PositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Business $business, Restaurant $restaurants)
{
    if($request->ajax()) {
        $positions = Positions::where('restaurant_id', $restaurants->id)->withTrashed();

        return DataTables::of($positions)
            ->addIndexColumn()
            ->addColumn('position', function ($row) {
                $html = '<div class="d-flex align-items-center">';
                $html .= '<div class="ms-3">';
                $html .= '<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">' . $row->name . '</a></h5>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })

            ->addColumn('description', function ($row){
                $description = $row->description ?? 'Sin Descripción';
                if (strlen($description) > 50) {
                    return '<span title="' . htmlspecialchars($description) . '">' . substr($description, 0, 50) . '...</span>';
                }
                return $description;
            })

            ->addColumn('salary_format', function ($row) {
                return '$ ' . number_format($row->base_salary, 2);
            })

            ->addColumn('salary_type', function ($row) {
                return DateHelper::translateSalaryType($row->salary_type);
            })

            ->addColumn('hours_per_day', function ($row) {
                return $row->hours_per_day;
            })

            ->addColumn('status', function ($row) {
                $status = '';
                if ($row->trashed()) {
                    $status .= '<div class="badge font-size-12 badge-soft-danger"> Suspendido </div>';
                } else {
                    $status .= '<div class="badge font-size-12 badge-soft-success"> Activo </div>';
                }
                return $status;
            })

            // btn editar
            ->addColumn('action', function ($row) use ($business, $restaurants) {
                $opciones = '<div class="d-flex gap-2">';

                $opciones .= '<a href="' . route('business.restaurants.positions.edit', [
                'business' => $business->slug,
                'restaurants' => $restaurants->slug,
                'position' => $row->id
            ]) . '" class="btn btn-sm text-warning action-icon icon-dual-warning p-1"><i class="mdi mdi-pencil font-size-18"></i></a>';

                
                if ($row->trashed()) {
                    // Btn restaurar
                    $opciones .= '<button type="button" onclick="btnRestorePosition(' . $row->id . ')" class="btn btn-sm text-primary action-icon icon-dual-secondary p-1"><i class="mdi mdi-restore font-size-18"></i></button>';
                    
                    // Btn eliminar 
                    $opciones .= '<button type="button" onclick="btnDeletePosition(' . $row->id . ')" class="btn btn-sm text-secondary action-icon icon-dual-secondary btnDelete p-1"><i class="mdi mdi-delete-empty font-size-18"></i></button>';
                } else {
                    // Btn suspender
                    $opciones .= '<button type="button" onclick="btnSuspendPosition(' . $row->id . ')" class="btn btn-sm text-secondary action-icon icon-dual-secondary p-1"><i class="mdi mdi-power-standby font-size-18"></i></button>';
                }
                
                return $opciones;
            })
            ->rawColumns(['position', 'description', 'salary_format', 'hours_per_day', 'status', 'action'])
            ->make(true);
    }
    $employees = Employees::where('restaurant_id', $restaurants->id)->get();
    $payroll_periods = PayrollPeriods::where('restaurant_id', $restaurants->id)->get();
    
    return view('payroll.index', compact('business', 'restaurants', 'employees', 'payroll_periods'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create(Business $business, Restaurant $restaurants)
    {
        $businessRestaurants = $business->restaurants;
        return view('payroll.positions.create', compact('business', 'restaurants', 'businessRestaurants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Business $business, Restaurant $restaurants, Request $request)
    {
        $data = $request->all();
        $data['restaurant_id'] = $restaurants->id;
        Positions::create($data);
        
        return redirect()->route('business.restaurants.positions.index', [
            'business' => $business, 
            'restaurants' => $restaurants
        ]);
    }

    /**
     * Suspend position
     */
    public function suspend(Business $business, Restaurant $restaurants, $id)
    {
        $position = Positions::findOrFail($id);
        $suspend = $position->delete();
        
        if ($suspend) {
            $success = true;
            $message = "Puesto suspendido correctamente";
        } else {
            $success = false;
            $message = "No fue posible suspender";
        }
        
        return response()->json([
            'success' => $success,
            'message' => $message
        ], 200);
    }

    /**
     * Restore position
     */
    public function restore(Business $business, Restaurant $restaurants, $id)
    {
        $position = Positions::onlyTrashed()->findOrFail($id);
        $restore = $position->restore();
        
        if ($restore == 1) {
            $success = true;
            $message = "Se restauró correctamente";
        } else {
            $success = false;
            $message = "Puesto no restaurado";
        }
        
        return response()->json([
            'success' => $success,
            'message' => $message
        ], 200);
    }

    // Métodos adicionales (pueden quedar vacíos si no los usas)
    public function show(string $id)
    {
        //
    }

    public function edit(Business $business, Restaurant $restaurants, $id)
    {
        $position = Positions::withTrashed()->findOrFail($id);
        return view('payroll.positions.edit', compact('business', 'restaurants', 'position'));
    }

    public function update(Request $request, Business $business, Restaurant $restaurants, $id)
    {
        $position = Positions::withTrashed()->findOrFail($id);
        $position->update($request->all());

        return redirect()->route('business.restaurants.positions.index', [
            'business' => $business->slug,
            'restaurants' => $restaurants->slug
        ])->with('success', 'Puesto actualizado correctamente');
    }

    /**
     * Destroy position permanently
     */
    public function destroy(Business $business, Restaurant $restaurants, $id)
    {
        $position = Positions::onlyTrashed()->findOrFail($id);

        if($position) {
            $delete = $position->forceDelete();
            return response()->json([
                'success' => $delete,
                'message' => $delete ? "Se eliminó permanentemente" : "No se pudo eliminar"
            ]);
            return response()->json(['success' => false, 'message' => 'Empleado no encontrado para eliminar']);
        }
    }
} 
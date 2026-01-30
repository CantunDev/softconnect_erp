<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Employees;
use App\Models\Positions;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\DateHelper;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Business $business, Restaurant $restaurants)
    {
        if ($request->ajax()) {
            $employees = Employees::where('restaurant_id', $restaurants->id)->withTrashed();

            return DataTables::of($employees)
                ->addIndexColumn()
                ->addColumn('full_name', function ($row) {

                    return $row->first_name . ' ' . $row->last_name . ' ' . $row->sur_name;
                })
                ->addColumn('status', function ($row) {
                    $status = '';
                    if ($row->trashed()) {
                        $status .= '<div class="badge font-size-12 badge-soft-danger"> Suspendido </div>';
                    } elseif ($row->status == 'active') {
                        $status .= '<div class="badge font-size-12 badge-soft-success"> Activo </div>';
                    } else {
                        $status .= '<div class="badge font-size-12 badge-soft-warning"> ' . ucfirst($row->status) . ' </div>';
                    }
                    return $status;
                })
                
                ->addColumn('action', function ($row) use ($business, $restaurants) {
                    $opciones = '<div class="d-flex gap-2">';

                    $opciones .= '<a href="' . route('business.restaurants.employees.show', [
                        'business' => $business->slug,
                        'restaurants' => $restaurants->slug,
                        'employee' => $row->id 
                    ]) . '" class="btn btn-sm text-info action-icon icon-dual-info p-1" title="Ver detalles">
                        <i class="mdi mdi-eye font-size-18"></i>
                    </a>';

                    // Btn Editar
                     $opciones .= '<a href="' . route('business.restaurants.employees.edit', [
                    'business' => $business->slug,
                    'restaurants' => $restaurants->slug,
                    'employee' => $row->id 
                ]) . '" class="btn btn-sm text-warning action-icon icon-dual-warning p-1"><i class="mdi mdi-pencil font-size-18"></i></a>';

                if ($row->trashed()) {
                    // Btn Restaurar
                    $opciones .= '<button type="button" onclick="btnRestoreEmployee(' . $row->id . ')" class="btn btn-sm text-primary action-icon icon-dual-secondary p-1"><i class="mdi mdi-restore font-size-18"></i></button>';
                    // Btn Eliminar
                    $opciones .= '<button type="button" onclick="btnDeleteEmployee(' . $row->id . ')" class="btn btn-sm text-secondary action-icon icon-dual-secondary btnDelete p-1"><i class="mdi mdi-delete-empty font-size-18"></i></button>';
                } else {
                    // Btn Suspender
                    $opciones .= '<button type="button" onclick="btnSuspendEmployee(' . $row->id . ')" class="btn btn-sm text-secondary action-icon icon-dual-secondary p-1"><i class="mdi mdi-power-standby font-size-18"></i></button>';
                }

                return $opciones;
            })
                
            ->rawColumns(['full_name', 'status', 'action'])
            ->make(true);
        }
        
        $employees = []; 
        $payroll_periods = [];
        
        return view('payroll.index', compact('business', 'restaurants', 'employees', 'payroll_periods'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(Business $business, Restaurant $restaurants, Request $request)
    {
        $businessRestaurants = $business->restaurants;
        $positions = Positions::where('restaurant_id',$restaurants->id)->get();

        return view('payroll.employees.create', compact('business', 'restaurants','businessRestaurants','positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Business $business, Restaurant $restaurants, Request $request)
    {
        // return $request->all();
        $data = $request->all();
        
        if (!empty($data['first_name'])) {
            $data['first_name'] = DateHelper::capitalizeName($data['first_name']);
        }
        
        if (!empty($data['last_name'])) {
            $data['last_name'] = DateHelper::capitalizeName($data['last_name']);
        }
        
        if (!empty($data['sur_name'])) {
            $data['sur_name'] = DateHelper::capitalizeName($data['sur_name']);
        }
        
        if (!empty($data['birth_place'])) {
            $data['birth_place'] = DateHelper::capitalizeName($data['birth_place']);
        }
        
        if (!empty($data['city'])) {
            $data['city'] = DateHelper::capitalizeName($data['city']);
        }
        
        if (!empty($data['state'])) {
            $data['state'] = DateHelper::capitalizeName($data['state']);
        }
        
        if (!empty($data['country'])) {
            $data['country'] = DateHelper::capitalizeName($data['country']);
        }
        
        if (!empty($data['address'])) {
            $data['address'] = DateHelper::capitalizeName($data['address']);
        }
        
        if (!empty($data['bank_name'])) {
            $data['bank_name'] = DateHelper::capitalizeName($data['bank_name']);
        }

        $data['restaurant_id'] = $restaurants->id;
        
        Employees::create($data);

        return redirect()->route('business.restaurants.employees.index', [
            'business' => $business->slug, 
            'restaurants' => $restaurants->slug
        ])->with('success', 'Empleado creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Business $business, Restaurant $restaurants, $id)
    {
        $employee = Employees::withTrashed()->findOrFail($id);
        
        return view('payroll.employees.show', compact('business', 'restaurants', 'employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Business $business, Restaurant $restaurants, $id)
    {
       $employee = Employees::withTrashed()->findOrFail($id);
        $positions = Positions::where('restaurant_id', $restaurants->id)->get();
        
        return view('payroll.employees.edit', compact('business', 'restaurants', 'employee', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Business $business, Restaurant $restaurants, $id)
    {
        $employee = Employees::withTrashed()->findOrFail($id);
        $data = $request->all();

        if (!empty($data['first_name'])) {
            $data['first_name'] = DateHelper::capitalizeName($data['first_name']);
        }
        
        if (!empty($data['last_name'])) {
            $data['last_name'] = DateHelper::capitalizeName($data['last_name']);
        }
        
        if (!empty($data['sur_name'])) {
            $data['sur_name'] = DateHelper::capitalizeName($data['sur_name']);
        }
        
        if (!empty($data['birth_place'])) {
            $data['birth_place'] = DateHelper::capitalizeName($data['birth_place']);
        }
        
        if (!empty($data['city'])) {
            $data['city'] = DateHelper::capitalizeName($data['city']);
        }
        
        if (!empty($data['state'])) {
            $data['state'] = DateHelper::capitalizeName($data['state']);
        }
        
        if (!empty($data['country'])) {
            $data['country'] = DateHelper::capitalizeName($data['country']);
        }
        
        if (!empty($data['address'])) {
            $data['address'] = DateHelper::capitalizeName($data['address']);
        }
        
        if (!empty($data['bank_name'])) {
            $data['bank_name'] = DateHelper::capitalizeName($data['bank_name']);
        }

        $employee->update($data);

        return redirect()->route('business.restaurants.employees.index', [
            'business' => $business->slug,
            'restaurants' => $restaurants->slug
        ])->with('success', 'Empleado actualizado correctamente');
    }

    public function suspend(Business $business, Restaurant $restaurants, $id)
    {
        $employee = Employees::findOrFail($id);
        $suspend = $employee->delete();
        
        return response()->json([
            'success' => $suspend,
            'message' => $suspend ? "Empleado suspendido correctamente" : "No fue posible suspender"
        ]);
    }

    public function restore(Business $business, Restaurant $restaurants, $id)
    {
        $employee = Employees::onlyTrashed()->find($id);
        
        if($employee) {
            $restore = $employee->restore();
            return response()->json([
                'success' => $restore,
                'message' => $restore ? "Se restauró correctamente" : "No restaurado"
            ]);
        }
        
        return response()->json(['success' => false, 'message' => 'Empleado no encontrado']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Business $business, Restaurant $restaurants, $id)
    {
        $employee = Employees::onlyTrashed()->find($id);

        if($employee) {
            $delete = $employee->forceDelete();
            return response()->json([
                'success' => $delete,
                'message' => $delete ? "Se eliminó permanentemente" : "No se pudo eliminar"
            ]);
        }
         return response()->json(['success' => false, 'message' => 'Empleado no encontrado para eliminar']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessRequest;
use App\Models\Business;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $business = Business::with(['users', 'restaurants'])->withTrashed();
            return DataTables::of($business)
                ->addIndexColumn()
                ->addColumn('business', function ($result) {
                    $imageUrl = $result->business_file
                        ? asset($result->business_file)
                        : 'https://avatar.oxro.io/avatar.svg?name=' . urlencode($result->name) . '&caps=3&bold=true';

                    $data = '<div class="d-flex align-items-center">';
                    $data .= '<img src="' . $imageUrl . '" alt="" class="rounded-circle avatar-xs">';
                    $data .= '<div class="ms-3">';
                    $data .= '<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">' . $result->name . '</a></h5>';
                    $data .= '<p class="text-muted mb-0">' .  ($result->business_name ? $result->business_name : 'Sin Razon Social') . '</p>';
                    $data .= '</div>';
                    $data .= '</div>';

                    return $data;
                })
                ->addColumn('users', function ($result) {
                    return $result->users && $result->users->count() > 0
                        ? 'Usuarios asignados: ' . $result->users->count()
                        : 'Sin usuarios';
                })
                ->addColumn('restaurants', function ($result) {
                    return $result->restaurants && $result->restaurants->count() > 0
                        ? 'Restaurantes asignados: ' . $result->restaurants->count()
                        : 'Sin restaurantes';
                })
                ->addColumn('action', function ($result) {
                    $opciones = '';
                    // if (Auth::user()->can('read_operators')){
                    // $opciones .= '<button type="button"  onclick="btnInfo('.$result->id.')" class="btn btn-sm action-icon icon-dual-blue"><i class="mdi mdi-dots-horizontal"></i></button>';
                    // }
                    // if (Auth::user()->can('update_operators')){
                    $opciones .= '<a href="' . route('business.edit', $result->id) . '" class="btn btn-sm text-warning action-icon icon-dual-warning p-1"><i class="mdi mdi-pencil font-size-18"></i></a>';
                    $opciones .= '<button type="button" onclick="btnRestore(' . $result->id . ')" class="btn btn-sm text-primary action-icon icon-dual-secondary p-1"><i class="mdi mdi-restore font-size-18"></i></button>';
                    // }
                    // if (Auth::user()->can('delete_operators')){
                    $opciones .= '<button type="button" onclick="btnSuspend(' . $result->id . ')" class="btn btn-sm text-secondary action-icon icon-dual-secondary p-1"><i class="mdi mdi-power-standby font-size-18"></i></button>';
                    $opciones .= '<button type="button" onclick="btnDelete(' . $result->id . ')" class="btn btn-sm text-secondary action-icon icon-dual-secondary btnDelete p-1"><i class="mdi mdi-delete-empty font-size-18"></i></button>';

                    // }
                    return $opciones;
                })
                ->addColumn('status', function ($result) {
                    $status = '';
                    if ($result->trashed()) {
                        $status .= '<div class="badge font-size-12 badge-soft-danger"> Suspendido </div>';
                    } else {
                        $status .= '<div class="badge font-size-12 badge-soft-success"> Activo </div>';
                    }
                    return $status;
                })
                ->rawColumns(['business', 'action', 'status'])
                ->make(true);
        }



        return view('business.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('business.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BusinessRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('business_file') && $request->file('business_file')->isValid()) {
            // Generar un nombre único para el archivo
            $imageName = Str::random(10) . '.' . $request->file('business_file')->getClientOriginalExtension();
        
            // Ruta al directorio dentro de `public`
            $destinationPath = public_path('assets/images/companies');
        
            // Crear la carpeta si no existe
            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
        
            // Mover el archivo a la ubicación deseada
            $request->file('business_file')->move($destinationPath, $imageName);
        
            // Guardar la ruta relativa para almacenarla en la base de datos
            $data['business_file'] = 'assets/images/companies/' . $imageName;
        }
        

        $business = Business::create($data);
        return redirect()->route('business.index');
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
    public function edit($id)
    {

        $business = Business::with('business_restaurants')->findOrFail($id);
        $restaurants = Restaurant::unassigned($id)->get();
        return view('business.edit', compact('business', 'restaurants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BusinessRequest $request, $id)
    { // return $request->all();
        $business = Business::findOrFail($id);
        $data = $request->validated();

        // Manejo del archivo si es válido
        if ($request->hasFile('business_file') && $request->file('business_file')->isValid()) {
            // Generar un nombre único para la imagen
            $imageName = Str::random(10) . '.' . $request->file('business_file')->getClientOriginalExtension();

            // Definir la ruta de almacenamiento relativa al directorio `public`
            $destinationPath = public_path('/assets/images/companies');

            // Crear la carpeta si no existe
            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Mover el archivo a la ubicación deseada
            $request->file('business_file')->move($destinationPath, $imageName);

            // Guardar la ruta relativa para almacenarla en la base de datos
            $data['business_file'] = '/assets/images/companies/' . $imageName;
        } else {
            // Mantener el archivo existente si no se proporciona uno nuevo
            $data['business_file'] = $business->business_file;
        }

        // Manejo de la relación con restaurantes
        if ($request->has('restaurant_ids')) {
            $restaurantIds = $request->restaurant_ids;
            $business->business_restaurants()->sync($restaurantIds);
        }

        // Actualizar los datos del negocio
        $business->update($data);

        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('business.index')->with('success', 'Business updated successfully!');
    }

    public function suspend($id)
    {
        $business = Business::findOrFail($id);
        $suspend = $business->delete();
        if ($suspend == 1) {
            $success = true;
            $message = "Empresa Suspendida";
        } else {
            $success = true;
            $message = "No fue posible suspendet";
        }
        return response()->json([
            'success' => $success,
            'message' => $message
        ], 200);
    }

    public function restore($id)
    {
        $business = Business::onlyTrashed($id);
        $restore = $business->restore();
        if ($restore == 1) {
            $success = true;
            $message = "Se restauro correctamene";
        } else {
            $success = true;
            $message = "Empresa no restaurada";
        }
        return response()->json([
            'success' => $success,
            'message' => $message
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $business = Business::onlyTrashed($id);
        $delete = $business->forceDelete();
        if ($delete == 1) {
            $success = true;
            $message = "Se elimino permanentemente";
        } else {
            $success = true;
            $message = "No se ha podido eliminar";
        }
        return response()->json([
            'success' => $success,
            'message' => $message
        ], 200);
    }
}

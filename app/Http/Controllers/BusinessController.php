<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessRequest;
use App\Models\Business;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                    $hex = str_replace('#', '', $result->color_secondary);

                    $imageUrl = $result->business_file
                        ? asset($result->business_file)
                        : 'https://avatar.oxro.io/avatar.svg?name=' . urlencode($result->name) . '&background=' . $hex . '&caps=3&bold=true';

                    $data = '<div class="d-flex align-items-center">';
                    $data .= '<img src="' . $imageUrl . '" alt="' . htmlspecialchars($result->name) . '" class="rounded-circle avatar-xs">';
                    $data .= '<div class="ms-3">';
                    $data .= '<h5 class="font-size-14 mb-1"><a href="javascript:void(0);" class="text-dark">' . htmlspecialchars($result->name) . '</a></h5>';
                    $data .= '<p class="text-muted mb-0">' . ($result->business_name ? htmlspecialchars($result->business_name) : 'Sin Razon Social') . '</p>';
                    $data .= '</div>';
                    $data .= '</div>';

                    return $data;
                })
                
                ->addColumn('users', function ($result) {
                    // 1. Si no hay usuarios
                    if ($result->users->isEmpty()) {
                        return '<span class="text-muted font-size-12">Sin usuarios</span>';
                    }

                    $html = '<div class="avatar-group">';

                    foreach ($result->users as $user) {
                        $imgUrl = $user->profile_photo_path 
                            ? asset($user->profile_photo_path) 
                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF';
                        
                        $name = htmlspecialchars($user->name);

                        $html .= '
                            <div class="avatar-group-item">
                                <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top" title="' . $name . '">
                                    <img src="' . $imgUrl . '" alt="" class="rounded-circle avatar-xs">
                                </a>
                            </div>';
                    }

                    $html .= '</div>'; // Cerrar grupo
                    return $html;
                })
                ->addColumn('restaurants', function ($result) {

                    if ($result->restaurants->isEmpty()) {
                        return '<span class="text-muted font-size-12">Sin restaurantes</span>';
                    }

                    $html = '<div class="avatar-group">';

                    foreach ($result->restaurants as $restaurant) {
                        
                        $imgUrl = $restaurant->restaurant_file 
                            ? asset(ltrim($restaurant->restaurant_file, '/')) 
                            : 'https://ui-avatars.com/api/?name=' . urlencode($restaurant->name) . '&color=F1B44C&background=FFF8E6';

                        $name = htmlspecialchars($restaurant->name);

                        $html .= '
                            <div class="avatar-group-item">
                                <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top" title="' . $name . '">
                                    <img src="' . $imgUrl . '" alt="' . $name . '" class="rounded-circle avatar-xs">
                                </a>
                            </div>';
                    }

                    $html .= '</div>'; 
                    return $html;
                })

                ->addColumn('action', function ($result) {
                    $opciones = '';
                    // if (Auth::user()->can('read_operators')){
                    // $opciones .= '<button type="button"  onclick="btnInfo('.$result->id.')" class="btn btn-sm action-icon icon-dual-blue"><i class="mdi mdi-dots-horizontal"></i></button>';
                    // }
                    if (Auth::user()->can('update_business')) {
                        if (!$result->trashed()) {
                            $opciones .= '<a href="' . route('business.edit', $result->id) . '" class="btn btn-sm text-warning action-icon icon-dual-warning p-1" title="Editar empresa" ><i class="mdi mdi-pencil font-size-18"></i></a>';
                            $opciones .= '<button type="button" onclick="btnSuspend(' . $result->id . ')" class="btn btn-sm text-secondary action-icon icon-dual-secondary p-1" title="Suspender empresa"><i class="mdi mdi-power-standby font-size-18"></i></button>';
                        }
                        if ($result->trashed()) {
                            $opciones .= '<button type="button" onclick="btnRestore(' . $result->id . ')" class="btn btn-sm text-primary action-icon icon-dual-secondary p-1" title="Restaurar empresa "><i class="mdi mdi-restore font-size-18"></i></button>';
                            if (Auth::user()->can('delete_business')) {
                                $opciones .= '<button type="button" onclick="btnDelete(' . $result->id . ')" class="btn btn-sm text-secondary action-icon icon-dual-secondary btnDelete p-1" title="Eliminar empresa"><i class="mdi mdi-delete-empty font-size-18"></i></button>';
                            }
                        }
                    }

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
                ->rawColumns(['business', 'action', 'status', 'users', 'restaurants'])
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

            // Ruta al directorio dentro de `public` además de poner el directory_separator para evitar problmeas con los slash
            $destinationPath = public_path('assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'companies');

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
    {
        //  return $request->all();
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
       $business->business_restaurants()->sync($request->input('restaurant_ids', []));

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
            $message = "No fue posible suspender";
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
            $message = "Se restauro correctamente";
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
            $success = false;
            $message = "No se ha podido eliminar";
        }
        return response()->json([
            'success' => $success,
            'message' => $message
        ], 200);
    }
}

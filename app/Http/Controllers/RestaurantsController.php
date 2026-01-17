<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantRequestStore;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class RestaurantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $restaurant = Restaurant::with('business', 'users')->withTrashed();
            return DataTables::of($restaurant)
                ->addIndexColumn()
                ->addColumn('restaurant', function ($result) {
                    $imageUrl = $result->restaurant_file
                        ? asset($result->restaurant_file)
                        : 'https://avatar.oxro.io/avatar.svg?name=' . urlencode($result->name) . '&caps=3&bold=true';
                    $data = '<div class="d-flex align-items-center">';
                    $data .= '<img src="' . $imageUrl . '" alt="" class="rounded-circle avatar-xs">';
                    $data .= '<div class="ms-3">';
                    $data .= '<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">' . $result->name . '</a></h5>';
                    $data .= '<p class="text-muted mb-0">' .  ($result->business ? $result->business->name : 'Sin empresa') . '</p>';
                    $data .= '</div>';
                    $data .= '</div>';

                    return $data;
                })
                ->addColumn('assigned', function ($result) {
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
                ->addColumn('action', function ($result) {
                    $opciones = '';
                    // if (Auth::user()->can('read_operators')){
                    // $opciones .= '<button type="button"  onclick="btnInfo('.$result->id.')" class="btn btn-sm action-icon icon-dual-blue"><i class="mdi mdi-dots-horizontal"></i></button>';
                    // }
                    if (Auth::user()->can('update_operators')){
                        if (!$result->trashed()) {
                            $opciones .= '<a href="' . route('restaurants.edit', $result->slug ?? $result->id) . '" class="btn btn-sm text-warning action-icon icon-dual-warning p-1"><i class="mdi mdi-pencil font-size-18"></i></a>';
                            $opciones .= '<button type="button" onclick="btnSuspend(' . $result->id . ')" class="btn btn-sm text-dark action-icon icon-dual-secondary p-1"><i class="mdi mdi-power-standby font-size-18"></i></button>';
                        }

                        if ($result->trashed()) {
                            $opciones .= '<button type="button" onclick="btnRestore(' . $result->id . ')" class="btn btn-sm text-primary action-icon icon-dual-secondary p-1"><i class="mdi mdi-restore font-size-18"></i></button>';
                            if (Auth::user()->can('delete_operators')){
                                $opciones .= '<button type="button" onclick="btnDelete(' . $result->id . ')" class="btn btn-sm text-danger action-icon icon-dual-secondary btnDelete p-1"><i class="mdi mdi-delete-empty font-size-18"></i></button>';

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
                // ->addColumn('action', function($result) {
                //     $buttons = [
                //         'view' => [
                //             'title' => 'View',
                //             'class' => 'btn-outline-primary',
                //             'icon' => 'mdi-eye-outline',
                //             'href' => '#'
                //         ],
                //         'edit' => [
                //             'title' => 'Edit',
                //             'class' => 'btn-outline-info',
                //             'icon' => 'mdi mdi-pencil',
                //             'href' => route('restaurants.edit', $result->id)
                //         ],
                //         'delete' => [
                //             'title' => 'Delete',
                //             'class' => 'btn-outline-danger',
                //             'icon' => 'mdi-delete-outline',
                //             'href' => '#restaurantDelete',
                //             'data-toggle' => 'modal'
                //         ]
                //     ];
                //     $output = '<ul class="list-unstyled hstack gap-1 mb-0">';
                //     foreach ($buttons as $key => $button) {
                //         $output .= sprintf(
                //             '<li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="%s">
                //                 <a href="%s" class="btn btn-sm %s" %s>
                //                     <i class="mdi %s"></i>
                //                 </a>
                //             </li>',
                //             $button['title'],
                //             $button['href'],
                //             $button['class'],
                //             isset($button['data-toggle']) ? 'data-bs-toggle="' . $button['data-toggle'] . '"' : '',
                //             $button['icon']
                //         );
                //     }
                //     $output .= '</ul>';

                //     return $output;
                // })
                ->rawColumns(['restaurant', 'action', 'status', 'assigned'])
                ->make(true);
        }
        return view('restaurantes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('restaurantes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RestaurantRequestStore $request)
    {
        $data = $request->validated();
        if ($request->hasFile('restaurant_file') && $request->file('restaurant_file')->isValid()) {
            // Generar un nombre único para el archivo
            $imageName = Str::random(10) . '.' . $request->file('restaurant_file')->getClientOriginalExtension();

            // Ruta al directorio dentro de `public`
            $destinationPath = public_path('assets/images/restaurants');

            // Crear la carpeta si no existe
            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Mover el archivo a la ubicación deseada
            $request->file('restaurant_file')->move($destinationPath, $imageName);

            // Guardar la ruta relativa para almacenarla en la base de datos
            $data['restaurant_file'] = 'assets/images/restaurants/' . $imageName;
        }
        $restaurant = Restaurant::create($data);
        return redirect()->route('restaurants.index');
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
    public function edit(Restaurant $restaurant)
    {
        return view('restaurantes.edit', compact('restaurant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RestaurantRequestStore $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $data = $request->validated();

        // Manejo del archivo si es válido
        if ($request->hasFile('restaurant_file') && $request->file('restaurant_file')->isValid()) {
            // Generar un nombre único para la imagen
            $imageName = Str::random(10) . '.' . $request->file('restaurant_file')->getClientOriginalExtension();

            // Definir la ruta de almacenamiento relativa al directorio `public`
            $destinationPath = public_path('/assets/images/restaurants');

            // Crear la carpeta si no existe
            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Mover el archivo a la ubicación deseada
            $request->file('restaurant_file')->move($destinationPath, $imageName);

            // Guardar la ruta relativa para almacenarla en la base de datos
            $data['restaurant_file'] = '/assets/images/restaurants/' . $imageName;
        } else {
            // Mantener el archivo existente si no se proporciona uno nuevo
            $data['restaurant_file'] = $restaurant->business_file;
        }

        $restaurant->update($data);

        return redirect()->route('restaurants.index');
    }

    public function suspend($id)
    {
        $restaurant = Restaurant::find($id);

        if ($restaurant) {
            $restaurant->delete(); // Esto aplica el SoftDelete
            return response()->json([
                'success' => true,
                'message' => "Restaurante Suspendido correctamente"
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Restaurante no encontrado o ya estaba suspendido"
            ], 404);
        }
    }

    public function restore($id)
    {
        $restaurant = Restaurant::onlyTrashed()->find($id);

        if ($restaurant) {
            $restaurant->restore();
            return response()->json([
                'success' => true,
                'message' => "Se restauró correctamente"
            ], 200);
        } else {
            
            return response()->json([
                'success' => false,
                'message' => "No se encontró el restaurante en la papelera"
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $business = Restaurant::onlyTrashed($id);
        $delete = $business->forceDelete();
        if ($delete == 1) {
            $success = true;
            $message = "Se elimino permanentemente";
        } else {
            $success = false;
            $message = "No se ha podido eliminar. Primero Suspenda la empresa";
        }
        return response()->json([
            'success' => $success,
            'message' => $message
        ], 200);
    }
}

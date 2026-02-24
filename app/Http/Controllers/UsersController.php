<?php

namespace App\Http\Controllers;

use App\Mail\CreateUserMail;
use App\Models\Business;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UserRequestStore;
use App\Http\Requests\UserRequestUpdate;
use App\Services\ImageService;
class UsersController extends Controller
{
  public function __construct(protected ImageService $imageService){}
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $users = User::withTrashed()->with(['business', 'restaurants']);
      return DataTables::of($users)
        ->addIndexColumn()
        ->addColumn('user', function ($result) {
          return '
                    <div class="d-flex align-items-center">
                        <img src="' .($result->avatar_url) . '"
                            class="rounded-circle avatar-xs me-2"
                            alt="' . e($result->full_name) . '">

                        <div>
                            <div class="fw-medium">' . e($result->full_name) . '</div>
                            <small class="text-muted">' . e($result->email) . '</small>
                        </div>
                    </div>
                ';
        })
       ->addColumn('business', fn($result) => $result->business->count() ?: 'Sin empresas')
       ->addColumn('restaurants', fn($result) => $result->restaurants->count() ?: 'Sin restaurantes')

          // if ($result->subtype?->isNotEmpty()) {
          //     $items = $result->subtype->map(function ($subtype) {
          //         return '<li>' . e($subtype->descripcion) . '</li>';
          //     })->join('');
          //     return '<ol>' . $items . '</ol>';
          // }
          // return 'Sin subtipos';
        ->addColumn('roles', function ($result) {
          $roleNames = $result->getRoleNames();
          if ($roleNames->isNotEmpty()) {
            $listItems = $roleNames->map(function ($role) {
              return "<li>{$role}</li>";
            })->implode('');
            return "<ul>{$listItems}</ul>";
          }
          return "<ul><li>Ningun Rol asignado</li></ul>";
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
        ->addColumn('action', function ($result) {
          $opciones = '';
          // if (Auth::user()->can('read_operators')){
          // $opciones .= '<button type="button"  onclick="btnInfo('.$result->id.')" class="btn btn-sm action-icon icon-dual-blue"><i class="mdi mdi-dots-horizontal"></i></button>';
          // }
          if (Auth::user()->can('update_users')) {
            $opciones .= '<a href="' . route('users.edit', $result->id) . '" class="btn btn-sm text-warning action-icon icon-dual-warning p-1"><i class="mdi mdi-pencil font-size-18"></i></a>';
            if ($result->trashed()) {
              $opciones .= '<button type="button" onclick="btnRestore(' . $result->id . ')" class="btn btn-sm text-primary action-icon icon-dual-secondary p-1"><i class="mdi mdi-restore font-size-18"></i></button>';
            }
          }
          if (Auth::user()->can('delete_users')) {
            $opciones .= '<button type="button" onclick="btnSuspend(' . $result->id . ')" class="btn btn-sm text-secondary action-icon icon-dual-secondary p-1"><i class="mdi mdi-power-standby font-size-18"></i></button>';
            if ($result->trashed()) {
              $opciones .= '<button type="button" onclick="btnDelete(' . $result->id . ')" class="btn btn-sm text-secondary action-icon icon-dual-secondary btnDelete p-1"><i class="mdi mdi-delete-empty font-size-18"></i></button>';
            }
          }
          return $opciones;
        })
        ->rawColumns(['user', 'roles', 'action', 'status'])
        ->make(true);
    }
    return view('users.index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $business = Business::all();
    return view('users.create', compact('business'));
  }

  /**
   * Store a newly created resource in storage.
   */
public function store(UserRequestStore $request)
{
    $validated = $request->validated();
    $validated['password'] = bcrypt($validated['name'] . '2024');

    if ($request->hasFile('user_file')) {
        $validated['user_file'] = $this->imageService->save(
        file:   $request->file('user_file'),
        folder: 'users',
        width:  400  
      );
    }
    $user = User::create($validated);
    
    $businessIds = array_filter($request->business_id ?? [], 'is_numeric');

    if (!empty($businessIds)) {
        $user->business()->attach($businessIds);
    }

    if ($request->filled('restaurant_ids')) {
      $restaurantIds = explode(',', $request->restaurant_ids);
      $user->restaurants()->attach($restaurantIds);
    }
    return redirect()->route('users.index');
}

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    return view('info');

  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $business = Business::all();
    $user = User::with(['business', 'restaurants'])->findOrFail($id);
    $selectedBusinessIds = $user->business->pluck('id')->toArray();
    $selectedRestaurantIds = $user->restaurants->pluck('id')->toArray();
    if (empty($selectedBusinessIds)) {
        $selectedBusinessIds[] = "";
    }
    if (empty($selectedRestaurantIds)) {
        $selectedRestaurantIds[] = "";
    }

    return view('users.edit', compact('user', 'business', 'selectedBusinessIds', 'selectedRestaurantIds'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UserRequestUpdate $request, $id)
  {
      $validated = $request->validated();
      
      // Buscar el usuario
      $user = User::findOrFail($id);
      
      // Manejar la imagen si se subió una nueva
      if ($request->hasFile('user_file')) {
          $validated['user_file'] = $this->imageService->save(
              file: $request->file('user_file'),
              folder: 'users',
              width: 400,
              oldImage: $user->user_file
          );
      }
      
      // Actualizar con los datos validados
      $user->update($validated);
      
      // Sincronizar business_id (si viene)
      $businessIds = array_filter($request->business_id ?? [], 'is_numeric');

      if (!empty($businessIds)) {
          $user->business()->attach($businessIds);
      }
      
      // Sincronizar restaurants - MANEJANDO CORRECTAMENTE EL CASO VACÍO
      if ($request->has('restaurant_ids') && !empty($request->restaurant_ids)) {
          $restaurantIds = explode(',', $request->restaurant_ids);
          // Filtrar valores vacíos
          $restaurantIds = array_filter($restaurantIds, function($id) {
              return !empty($id) && is_numeric($id);
          });
          
          if (!empty($restaurantIds)) {
              $user->restaurants()->sync($restaurantIds);
          } else {
              // Si después de filtrar no hay IDs válidos, sincronizar vacío
              $user->restaurants()->sync([]);
          }
      } elseif ($request->has('restaurant_ids')) {
          // Si restaurant_ids viene vacío, eliminar todas las relaciones
          $user->restaurants()->sync([]);
      }
      
      return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente');
  }

  public function suspend($id)
  {
    $user = User::findOrFail($id);
    $suspend = $user->delete();
    if ($suspend == 1) {
      $success = true;
      $message = "Usuario Suspendido";
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
    $user = User::onlyTrashed($id);
    $restore = $user->restore();
    if ($restore == 1) {
      $success = true;
      $message = "Se restauro correctamene";
    } else {
      $success = true;
      $message = "Restaurante no restaurado";
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
    $user = User::onlyTrashed()
            ->where('id', $id)
            ->firstOrFail();
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Usuario no encontrado o no está en papelera'
        ], 404);
    }

    try {
      if ($user->business()->exists() || $user->restaurants()->exists()) {
        return response()->json([
            'success' => false,
            'message' => 'No puedes eliminar: usuario aún relacionado'
        ], 409);
    }
        $user->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Se eliminó permanentemente'
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => 'No se ha podido eliminar',
            'error' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}
}

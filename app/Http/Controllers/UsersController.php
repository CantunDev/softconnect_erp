<?php

namespace App\Http\Controllers;

use App\Mail\CreateUserMail;
use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $users = User::withTrashed();
      return DataTables::of($users)
        ->addIndexColumn()
        ->addColumn('user', function ($result) {
          $imageUrl = $result->user_file ? !is_null($result->user_file) :
            'https://avatar.oxro.io/avatar.svg?name=' . $result->fullname . '&caps=3&bold=true';
          $data = '<div class="d-flex align-items-center">';
          $data .= '<img src="' . $imageUrl . '" alt="" class="rounded-circle avatar-xs">';
          $data .= '<div class="ms-3">';
          $data .= '<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">' . $result->fullname . '</a></h5>';
          $data .= '<p class="text-muted mb-0">' . $result->email . '</p>';
          $data .= '</div>';
          $data .= '</div>';

          return $data;
        })
        ->addColumn('business', function ($result) {
          return $result->business && $result->business->count() > 0
            ? $result->business->count()
            : 'Sin empresas';
        })
        ->addColumn('restaurants', function ($result) {
          return $result->restaurants && $result->restaurants->count() > 0
            ? $result->restaurants->count()
            : 'Sin restaurantes';

          // if ($result->subtype?->isNotEmpty()) {
          //     $items = $result->subtype->map(function ($subtype) {
          //         return '<li>' . e($subtype->descripcion) . '</li>';
          //     })->join('');
          //     return '<ol>' . $items . '</ol>';
          // }
          // return 'Sin subtipos';
        })
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
  public function store(Request $request)
  {
    // return $request->all();
    $user = new User($request->all());
    //  if ($request->has('photo_user')) {
    //     $photo = $request->file('photo_user');
    //      $avatar =  $user->email.'.'.$photo->getClientOriginalExtension();
    //      $path = public_path('/assets/images/users/');
    //      $photo_user = $path . $avatar;
    //      Image::make($photo)->resize(150, 150)->save($photo_user);
    // }
    // $data = $request->validated();

    // if ($request->hasFile('restuarnt_file') && $request->file('restuarnt_file')->isValid()) {
    //     $imageName = Str::random(10) . '.' . $request->file('restuarnt_file')->getClientOriginalExtension();
    //     $request->file('restuarnt_file')->storeAs('restaurant', $imageName);
    //     $data['restuarnt_file'] = $imageName;
    // }
    $user->password = bcrypt($request->name . '2024');
    $user->save();
    // Mail::to('cantunberna@gmail.com')->send(new CreateUserMail($user));
    // Mail::to($user->email)->send(new CreateUserMail($user));
    if ($request->has('busines_id')) {
      $user->business()->attach($request->business_id);
    }
    if ($request->has('restaurant_ids')) {
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
    return view('users.edit', compact('user', 'business'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    // return $request->all();
    $user_find = User::findOrFail($id);
    $user = $user_find->update($request->all());
    $user_find->business()->sync($request->business_id);
    $restaurantIds = explode(',', $request->restaurant_ids);
    $user_find->restaurants()->sync($restaurantIds);

    // $restaurant = Restaurant::create($data);
    return redirect()->route('users.index');
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
    $user = User::onlyTrashed($id);
    $delete = $user->forceDelete();
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

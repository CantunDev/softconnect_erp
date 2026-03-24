<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redis;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Business;
use App\Models\Restaurant;
class RolesPermissionsController extends Controller
{
    public function index(Request $request)
    {
        return  view('roles_permissions.index');
    }

    public function create()
    {
        $permisos_cat = Permission::groupBy('category')->get();
        $permisos = Permission::all();
        $users = $this->getUsersWithRelations();

        // Artisan::call('optimize:clear');

        return view('roles_permissions.create', compact('permisos_cat', 'permisos', 'users'));
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permisos_cat = Permission::groupBy('category') ->get();
        $permisos = Permission::all();
        Artisan::call('optimize:clear');
        $users = $this->getUsersWithRelations();
        return view('roles_permissions.edit', compact('role', 'permisos_cat', 'permisos', 'users'));
    }

    public function store(Request $request)
    {
        $role = Role::create($request->all());
        $role->permissions()->sync($request->get('permission'));
        $role->users()->sync($request->get('users'));
        
        return view('roles_permissions.index');
    }

    public function update(Request $request, $id)
    {
        // return  $request->all();
        $role = Role::findOrFail($id);
        $role->permissions()->sync($request->get('permission'));
        $role->users()->sync($request->get('users'));

        return view('roles_permissions.index');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role = $role->delete();
        if ($role == 1){
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

    private function getUsersWithRelations()
    {
        return User::select('id', 'name', 'email', 'user_file')
            ->with([
                'business:id,name,business_file',
                'restaurants:id,name,restaurant_file',
                'restaurants.business:id,name',  // para detectar si el restaurante es standalone
            ])
            ->orderBy('name')
            ->get();
    }
}

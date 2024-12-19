<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redis;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        Artisan::call('optimize:clear');
        return view('roles_permissions.create', compact('permisos_cat', 'permisos'));
    }

    public function edit($id)
    {
        $roles = Role::findOrFail($id);
        $permisos_cat = Permission::groupBy('category') ->get();
        $permisos = Permission::all();
        Artisan::call('optimize:clear');
        return view('roles_permissions.edit', compact('roles', 'permisos_cat', 'permisos'));
    }

    public function store(Request $request)
    {
        $role = Role::create($request->all());
        $role->permissions()->sync($request->get('permission'));
        return view('roles_permissions.index');
    }

    public function update(Request $request, $id)
    {
        // return  $request->all();
        $role = Role::findOrFail($id);
        $role->permissions()->sync($request->get('permission'));
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
}

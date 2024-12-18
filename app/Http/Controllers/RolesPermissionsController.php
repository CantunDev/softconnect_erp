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

    public function edit($id)
    {
        // $roles = Role::findOrFail($id);
        // $permissions = Permission::all();
        // $permisos_cat = Permission::all()->get('category');

        $roles = Role::findOrFail($id);
        $permisos_cat = Permission::groupBy('category')
                    // ->orderBy('created_at')
                    ->get();
        $permisos = Permission::all();

        return view('roles_permissions.edit', compact('roles', 'permisos_cat','permisos'));
    }

    public function update(Request $request, $id)
    {
        // return  $request->all();
        $role = Role::findOrFail($id);
        $role->permissions()->sync($request->get('permission'));
        Artisan::call('optimize:clear');
        return view('roles_permissions.index');
    }
}

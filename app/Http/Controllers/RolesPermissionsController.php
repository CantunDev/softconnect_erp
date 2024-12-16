<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RolesPermissionsController extends Controller
{
    public function index(Request $request)
    {
        return  view('roles_permissions.index');
    }

    
}

<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Restaurant;
use App\Models\Sfrt\TypeProviders;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TypeProvidersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Business $business, Restaurant $restaurants, Request $request)
    {
        if ($request->ajax()) {
            $type_providers = TypeProviders::query();
            return DataTables::of($type_providers)
                ->addIndexColumn()
                ->filter(function ($query) {
                    if (request()->has('search') && !empty(request('search')['value'])) {
                        $searchValue = request('search')['value'];
                        $query->where(function ($q) use ($searchValue) {
                            $q->where('descripcion', 'like', '%' . $searchValue . '%')
                                ->orWhere('idtipoproveedor', 'like', '%' . $searchValue . '%');
                        });
                    }
                })
                ->addColumn('actions', function ($result) use ($business, $restaurants) {
                    $actions = '';
                    // Botón Editar
                    $actions .= '<a href="' . route('business.restaurants.providers.edit', [
                        'business' => $business->slug,
                        'restaurants' => $restaurants->slug,
                        'provider' => $result->idtipoproveedor
                    ]) . '" class="btn btn-sm text-warning action-icon icon-dual-warning p-1" title="Editar">
                    <i class="mdi mdi-pencil font-size-18"></i>
                </a>';

                    // Botón Suspender (solo si está activo)
                    $formattedId = str_pad($result->idtipoproveedor, 2, '0', STR_PAD_LEFT);
                    $actions .= '<button type="button" onclick="btnSuspend(' . $formattedId . ')" 
                        class="btn btn-sm text-secondary action-icon icon-dual-secondary p-1" title="Suspender">
                        <i class="mdi mdi-delete-empty font-size-18"></i>
                    </button>';

                    return $actions;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Business $business, Restaurant $restaurants, Request $request)
    {
        $validated = $request->validate([
            'idtipoproveedor' => 'nullable','unique:sqlsrv.tipoproveedores,nombre',
            'descripcion' => 'required'
        ]);
        
        $typeprovider = TypeProviders::on('sqlsrv')->create($validated); // o 'sqlsrv'

        return response()->json([
            'success' => true,
            'message' => 'Tipo de proveedor creado exitosamente'
        ]);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

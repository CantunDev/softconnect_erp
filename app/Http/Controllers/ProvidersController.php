<?php

namespace App\Http\Controllers;

use App\Events\ProviderEvents;
use App\Helpers\DateHelper;
use App\Http\Requests\StoreProviderRequest;
use App\Models\Business;
use App\Models\Restaurant;
use App\Models\Sfrt\AccountingAccount;
use App\Models\Sfrt\Provider;
use App\Models\Sfrt\TypeProviders;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProvidersController extends Controller
{

    public function index(Business $business, Restaurant $restaurants,  Request $request, DateHelper $date_helper)
    {
        if ($request->ajax()) {
            $providers = Provider::query();
            // $providers = Provider::query()->orderByName('asc');
            return DataTables::of($providers)
                ->addIndexColumn()
                ->addColumn('name', function ($result) {
                    return $name = '
                    <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">' . $result->nombre . '</a></h5>
                    <p class="text-muted mb-0">' . $result->razonsocial . '</p>';
                })
                ->filter(function ($query) {
                    if (request()->has('search') && !empty(request('search')['value'])) {
                        $searchValue = request('search')['value'];
                        $query->where(function ($q) use ($searchValue) {
                            $q->where('nombre', 'like', '%' . $searchValue . '%')
                                ->orWhere('razonsocial', 'like', '%' . $searchValue . '%');
                        });
                    }
                })
                ->addColumn('action', function ($result) {
                    $opciones = '';
                    if (Auth::user()->can('read_providers')) {
                        $opciones .= '<button type="button"  onclick="btnInfo(' . $result->id . ')" class="btn btn-sm text-info action-icon icon-dual-blue"><i class="mdi mdi-information-outline font-size-18"></i></button>';
                    }
                    return $opciones;
                })
                ->addColumn('purchases', function ($result) {
                    return $result->purchases->count();
                })
                ->addColumn('average', function ($result) {
                    return round($result->purchases->avg('total'), 2) ?? 0.0;
                })
                ->addColumn('status', function ($result) {
                    return $result->estatus <= 1 
                    ? '<span class="badge bg-success">ACTIVO</span>'
                    : '<span class="badge bg-danger">BAJA</span>';

                })
                ->addColumn('actions', function ($result) use ($business, $restaurants) {
                    $actions = '';
                    if ($result->estaActivo()) {

                        // Botón Ver (con ruta si es necesario)
                        $actions .= '<a href="' . route('business.restaurants.providers.show', [
                            'business' => $business->slug,
                            'restaurants' => $restaurants->slug,
                            'provider' => $result->idproveedor
                        ]) . '" class="btn btn-sm text-info action-icon icon-dual-warning p-1" title="Ver">
        <i class="mdi mdi-eye font-size-18"></i>
    </a>';

                        // Botón Editar
                        $actions .= '<a href="' . route('business.restaurants.providers.edit', [
                            'business' => $business->slug,
                            'restaurants' => $restaurants->slug,
                            'provider' => $result->idproveedor
                        ]) . '" class="btn btn-sm text-warning action-icon icon-dual-warning p-1" title="Editar">
        <i class="mdi mdi-pencil font-size-18"></i>
    </a>';

                        // Botón Suspender (solo si está activo)
                        $formattedId = str_pad($result->idproveedor, 2, '0', STR_PAD_LEFT);
                        $actions .= '<button type="button" onclick="btnSuspend(' . $formattedId . ')" 
            class="btn btn-sm text-secondary action-icon icon-dual-secondary p-1" title="Suspender">
            <i class="mdi mdi-delete-empty font-size-18"></i>
        </button>';
                    }

                    return $actions;
                })
                ->rawColumns(['name', 'actions', 'status'])
                ->make(true);
        }
        return view('providers.index', compact('business', 'restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Business $business, Restaurant $restaurants)
    {
        // Tipo de proveedores
        $tipoproveedores = TypeProviders::all();
        // Cuentas contables
        $cuentascontables = AccountingAccount::where('tipo', 2)->get();

        return view('providers.create', compact('business', 'restaurants', 'tipoproveedores', 'cuentascontables'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Business $business, Restaurant $restaurants, StoreProviderRequest $request)
    {
        // $request->all();
        $validated = $request->validated();
        // $connectionName = Provider::query()->getConnection()->getName();
        // Log::info("Creando Provider con conexión: ".$connectionName);
        $lastId = DB::connection('sqlsrv')
            ->table('proveedores')
            ->max('idproveedor');

        $validated['idproveedor'] = $lastId + 1;
        // $provider = new Provider();
        $provider = Provider::on('sqlsrv')->create($validated); // o 'sqlsrv'
        event(new ProviderEvents($provider->idproveedor, 'created', Auth::user()));
        Log::info('Después de disparar ProviderEvents');

        return redirect()->route(
            'business.restaurants.providers.index',
            [
                'business' => $business->slug,
                'restaurants' => $restaurants->slug
            ]
        )
            ->with('success', 'Proveedor creado correctamente.');
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
    public function edit(Business $business, Restaurant $restaurants, $providers)
    {
        $provider = Provider::where('idproveedor', $providers)->first();
        // Tipo de proveedores
        $tipoproveedores = TypeProviders::all();
        // Cuentas contables
        $cuentascontables = AccountingAccount::where('tipo', 2)->get();
        return view('providers.edit', compact('business', 'restaurants', 'provider', 'tipoproveedores', 'cuentascontables'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Business $business, Restaurant $restaurants, Request $request, $provider)
    {
        // return $request->all();
        $provider = Provider::where('idproveedor', $provider)->firstOrFail();

        $provider->update($request->all());
        return redirect()->route('business.restaurants.providers.index', [$business->slug, $restaurants->slug])
            ->with('success', 'Proveedor actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $provider = Provider::findOrFail($request->id);
        $provider->delete();
        return redirect()->route('providers.index');
    }

    public function suspend(Business $business, Restaurant $restaurants,  $provider)
    {
        $provider = Provider::where('idproveedor', $provider)->first();
        $provider->estatus = 2;
        $suspend = $provider->save();
        if ($suspend == 1) {
            $success = true;
            $message = "Proveedor Suspendido";
        } else {
            $success = true;
            $message = "No fue posible suspender";
        }
        return response()->json([
            'success' => $success,
            'message' => $message
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Http\Requests\StoreProviderRequest;
use App\Models\Business;
use App\Models\Restaurant;
use App\Models\Sfrt\Provider;
use Illuminate\Http\Request;
use Illuminate\Queue\Console\RestartCommand;
use Illuminate\Support\Composer;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use LaravelLang\Publisher\Console\Reset;

class ProvidersController extends Controller
{

    public function index(Business $business, Restaurant $restaurants,  Request $request, DateHelper $date_helper)
    {
        if ($request->ajax()) {
            $providers = Provider::query();
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
                    $status = '';
                    if ($result->estatus <= 1) {
                        $status .= '<span class="badge bg-success me-1">ACTIVO</span>';
                    } else {
                        $status .= '<span class="badge bg-danger me-1">BAJA</span>';
                    }
                    return $status;
                })
                ->addColumn('actions', function ($result) {
                    $actions = '';
                    $actions .= '<a href="" class="btn btn-sm text-info action-icon icon-dual-warning p-1"><i class="mdi mdi-eye font-size-18"></i></a>';
                    $actions .= '<a href="" class="btn btn-sm text-warning action-icon icon-dual-warning p-1"><i class="mdi mdi-pencil font-size-18"></i></a>';
                    $actions .= '<button type="button" onclick="btnDelete(' . $result->id . ')" class="btn btn-sm text-secondary action-icon icon-dual-secondary btnDelete p-1"><i class="mdi mdi-delete-empty font-size-18"></i></button>';
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
        // $tipoproveedores = 
        // Cuentas contables
        // $cuentascontables
        return view('providers.create', compact('business','restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Business $business, Restaurant $restaurants, StoreProviderRequest $request)
    {
        // return $request->all();
        $validated = $request->validated();
        return $request->all();
        $provider = Provider::create($request->all());
        return redirect()->route('providers.index');
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
    public function edit(Provider $provider)
    {
        return view('providers.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provider $provider)
    {
        $provider->update($request->all());
        return redirect()->route('providers.index');
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
}

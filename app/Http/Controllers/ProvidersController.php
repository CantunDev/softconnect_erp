<?php

namespace App\Http\Controllers;

use App\Models\Cheques;
use App\Models\Provider;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ProvidersController extends Controller
{

    public function index()
    {
        /*INDEX PARA PROVEEDORES */
        $providers = Provider::all();
        return view('providers.index', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('providers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

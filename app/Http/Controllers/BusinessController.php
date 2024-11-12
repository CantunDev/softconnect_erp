<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessRequest;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Business::orderBy('id', 'desc')->paginate(10);
        return view('business.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('business.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BusinessRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('business_file') && $request->file('business_file')->isValid()) {
            $imageName = Str::random(10) . '.' . $request->file('business_file')->getClientOriginalExtension();
            $request->file('business_file')->storeAs('business', $imageName);
            $data['business_file'] = $imageName;
        }

        $business = Business::create($data);
        return redirect()->route('business.index');
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
    public function edit($id)
    {
        $business = Business::findOrFail($id);
        return view('business.edit', compact('business'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BusinessRequest $request, $id)
    {
        $business = Business::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('business_file') && $request->file('business_file')->isValid()) {
            $imageName = Str::random(10) . '.' . $request->file('business_file')->getClientOriginalExtension();
            $request->file('business_file')->storeAs('business', $imageName);
            $data['business_file'] = $imageName;
        } else {
            $data['business_file'] = $business->business_file;
        }

        $business->update($data);

        return redirect()->route('business.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $business = Business::findOrFail($id);
        $business->delete();
        return redirect()->route('business.index');
    }
}

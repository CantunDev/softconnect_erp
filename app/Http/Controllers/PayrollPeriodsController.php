<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\PayrollPeriods;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class PayrollPeriodsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Business $business, Restaurant $restaurants)
    {
        $businessRestaurants = $business->restaurants;
        return view('payroll.periods.create',compact('business','restaurants','businessRestaurants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Business $business, Restaurant $restaurants, Request $request)
    {
        $payroll = PayrollPeriods::create($request->all());
        return redirect()->route('business.restaurants.payroll.index',['business' => $business, 'restaurants' => $restaurants]);
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

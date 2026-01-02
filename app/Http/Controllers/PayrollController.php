<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request, Business $business, Restaurant $restaurants)
    {
        return view('payroll.index', compact('business', 'restaurants'));

    }
}

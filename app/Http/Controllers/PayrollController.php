<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Employees;
use App\Models\PayrollPeriods;
use App\Models\Positions;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request, Business $business, Restaurant $restaurants)
    {
        $positions = Positions::where('restaurant_id',$restaurants->id)->get();
        $employees = Employees::where('restaurant_id',$restaurants->id)->get();
        $payroll_periods = PayrollPeriods::where('restaurant_id',$restaurants->id)->get();

        return view('payroll.index', compact('business', 'restaurants','employees','positions','payroll_periods'));
    }
}

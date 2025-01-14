<?php

namespace App\Providers;

use App\Models\Sfrt\Cheques;
use App\Models\Sfrt\Group;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Carbon\CarbonPeriod;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // DB::listen(function ($query) {
        //     logger($query->sql);
        //     logger($query->bindings);
        // });
        // Implicitly grant "Super-Admin" role all permission checks using can()
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('Super-Admin')) {
                return true;
            }
        });

        view()->composer(['layouts.master','dashboard'], function($view){
            $day = Carbon::now(); // Esto conserva la fecha como objeto Carbon
            $startOfMonth = Carbon::now()->startOfMonth()->format('d-m-y');
            $endOfMonth = Carbon::now()->endOfMonth()->format('d-m-y');
            $month = Carbon::now()->translatedFormat('F');
            $daysInMonth = Carbon::now()->daysInMonth;
            // $daysPass = $day->diffInDays($day->startOfMonth()) + 1;
            $daysPass = $day->day - 2;  
            $view->with([
                // 'clients_avg' => number_format($clients_avg,2),
                'startOfMonth' => $startOfMonth,
                'endOfMonth' => $endOfMonth,
                'month' => $month,
                'daysInMonth' => $daysInMonth,
                'daysPass' => $daysPass
            ]);
        });
        
    }
}

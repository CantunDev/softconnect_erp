<?php

namespace App\Providers;

use App\Models\Sfrt\Cheques;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

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
            $currentMonth = Carbon::now()->month;
            $clients_sum = Cheques::whereMonth('fecha', $currentMonth)->sum('nopersonas');
            $cheques = Cheques::whereMonth('fecha', $currentMonth);
            // $clients_sum = Cheques::whereMonth('fecha', $currentMonth)->sum('total');
            // $services = DB::table('registers')
            //                 ->select(
            //                     array(
            //                         DB::raw('type_service_id as title'),
            //                         DB::raw('date as start'),
            //                         DB::raw('date as end'),
            //                         DB::raw('passenger as description'),
            //                         ))
            //                 ->get();
            // $sales = Assign
            $view->with([
                // 'clients_avg' => number_format($clients_avg,2),
                'cheques' => $cheques,
                'currentMonth' => $currentMonth,
                'clients_sum' => $clients_sum,
            ]);
        });

    }
}

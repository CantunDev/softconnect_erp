<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\RestaurantsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\FetchDataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectionController;
use App\Http\Controllers\ProjectionDayController;
use App\Http\Controllers\ProvidersController;
use App\Http\Controllers\TypeProvidersController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ExpensesCategoriesController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\Export\PdfController;
use App\Http\Controllers\Export\ExcelController;
use App\Http\Controllers\RolesPermissionsController;
use App\Http\Controllers\CashMovementsController;
//Redirect to login
Route::get('/', fn() => redirect('login'));
/**
 * AUTH ROUTES
 */
Route::middleware(['auth', 'verified'])->group(function () {
    
    /**
     *----------------------------------------------------
     * ROUTES GENERALES
     *----------------------------------------------------
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/info', [InfoController::class, 'index'])->name('info'); /**/REMOVER CONTROLADOR */
    /**
     *----------------------------------------------------
     * CONFIG ROUTES 
     *----------------------------------------------------
     */
    Route::prefix('config')->name('config.')->group(function () {

        Route::resource('users', UsersController::class);
        Route::resource('roles_permissions', RolesPermissionsController::class);
        Route::resource('business', BusinessController::class);
        Route::resource('restaurants', RestaurantsController::class); 
        Route::resource('profile', ProfileController::class)->except(['create','store']);   
        /**
         *----------------------------------------------------
         * RESTORE / SUSPEND / FETCH
         *----------------------------------------------------
         */
        Route::prefix('restore')->name('restore.')->group(function () {
            Route::put('restaurants/{restaurant}', [RestaurantsController::class, 'restore']);
            Route::put('/users/{user}', [UsersController::class, 'restore']);
            Route::put('/business/{business}', [BusinessController::class, 'restore']);
            Route::put('/payment_method/{accounting}', [PaymentMethodController::class, 'restore']);
        });
        Route::prefix('suspend')->group(function () {
            Route::put('/restaurants/{restaurant}', [RestaurantsController::class, 'suspend']);
            Route::put('/payment_method/{accounting}', [PaymentMethodController::class, 'suspend']);
            Route::put('/users/{user}', [UsersController::class, 'suspend']);
            Route::put('/business/{business}', [BusinessController::class, 'suspend']);
        });
        Route::prefix('fetch')->group(function () {
            Route::get('/categories', [FetchDataController::class, 'getCategories'])->name('categories.get');
            Route::get('/subcategories/{id}', [FetchDataController::class, 'getSubcategories'])->name('subcategories.get');
            Route::post('/restaurants',[FetchDataController::class, 'getRestaurants'])->name('restaurants.get');
            Route::get('/restaurants/bussiness/{businessId}', [FetchDataController::class, 'getByBusiness'])->name('restaurants.byBusiness');
            Route::get('roles/',[FetchDataController::class, 'getRoles'])->name('roles.get');
            Route::get('permissions/', [FetchDataController::class, 'getPermissions'])->name('permissions.get');
        });

    });

    /*
    |----------------------------------------------------------------------
    | ROUTES Reutilizables
    |----------------------------------------------------------------------
    */
    
    $reportsRoutes = function () {
        Route::prefix('exports')->name('export.')->group(function () {
            Route::prefix('pdf')->name('pdf.')->group(function () {
                Route::get('monthly', [PdfController::class, 'exportPdf'])->name('monthly');
            });
            Route::prefix('excel')->name('excel.')->group(function () {
                Route::get('monthly', [ExcelController::class, 'exportExcel'])->name('monthly');
            });
        });
    };

    $operationsRoutes = function () {
        Route::get('/home/filter', [HomeController::class, 'filter'])->name('home.filter');
        Route::resource('home', HomeController::class);

        Route::resource('projections', ProjectionController::class);
        Route::get('/monthly', [ProjectionController::class, 'getProjectionsMonthly'])->name('projections_monthly.get');
        Route::prefix('projections/{month}')->name('projections.month.')->group(function () {
            Route::resource('monthly', ProjectionDayController::class);
            Route::get('sales_get',    [ProjectionDayController::class, 'sales_get'])->name('sales.get');
            Route::put('sales_update', [ProjectionDayController::class, 'sales_update'])->name('sales.update');
        });

        Route::resource('providers', ProvidersController::class);
        Route::resource('typeproviders', TypeProvidersController::class);
        Route::resource('invoices', InvoicesController::class);
        Route::resource('payment_method', PaymentMethodController::class);
        Route::resource('expenses_categories', ExpensesCategoriesController::class);
        Route::resource('expenses', ExpensesController::class);
        Route::resource('cash_movements', CashMovementsController::class);

        Route::prefix('suspend')->group(function () {
            Route::put('/providers/{providers}', [ProvidersController::class, 'suspend'])->name('providers.suspend');
        });
    };

    $restaurantRoutes = function () use ($operationsRoutes, $reportsRoutes) {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        $operationsRoutes();
        $reportsRoutes();
    };

     
    /*
    |--------------------------------------------------------------------------
    | 3. Solo Restaurante  →  /{restaurant}/...
    |--------------------------------------------------------------------------
    */
    Route::prefix('{restaurants:slug}')
        ->name('restaurants.')
        ->group($restaurantRoutes);
    /*
    |--------------------------------------------------------------------------
    | 1. Empresa con Restaurante  →  /{business}/{restaurant}/...
    |--------------------------------------------------------------------------
    */
    Route::prefix('{business:slug}/{restaurants:slug}')
        ->name('business.restaurants.')
        ->group($restaurantRoutes);

    /*
    |--------------------------------------------------------------------------
    | 2. Solo Empresa  →  /{business}/...
    |--------------------------------------------------------------------------
    */
    Route::prefix('{business:slug}')->name('business.')->group(function () use ($operationsRoutes, $reportsRoutes) {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        $operationsRoutes();
        $reportsRoutes();
    });
   

});

require __DIR__ . '/auth.php';
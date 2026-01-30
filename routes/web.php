<?php

use App\Http\Controllers\AttendanceRecordsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ChequesController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ExpensesCategoriesController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\FetchDataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PayrollPeriodsController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectionController;
use App\Http\Controllers\ProjectionDayController;
use App\Http\Controllers\ProvidersController;
use App\Http\Controllers\RestaurantsController;
use App\Http\Controllers\RolesPermissionsController;
use App\Http\Controllers\TypeProvidersController;
use App\Http\Controllers\UsersController;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// Ruta para la validación AJAX del email
Route::get('test', function(){
    $name = 'Berna';
    Mail::to('cantunberna@gmail.com')->send(new WelcomeEmail($name));
});
Route::post('/check-email', [AuthenticatedSessionController::class, 'checkEmail'])
    ->middleware('guest')
    ->name('check-email');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/info', [InfoController::class, 'index'])->name('info');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UsersController::class);
    Route::resource('business', BusinessController::class);
    Route::resource('restaurants', RestaurantsController::class);
    Route::resource('cheques', ChequesController::class);
    Route::resource('roles_permissions', RolesPermissionsController::class);

    Route::prefix('restore')->group(function () {
        Route::put('/restaurants/{restaurant}', [RestaurantsController::class, 'restore'])->name('restaurants.restore');
        Route::put('/payment_method/{accounting}', [PaymentMethodController::class, 'restore'])->name('payment_method.restore');
        Route::put('/users/{user}', [UsersController::class, 'restore'])->name('users.restore');
        Route::put('/business/{business}', [BusinessController::class, 'restore'])->name('business.restore');
    });
    Route::prefix('suspend')->group(function () {
        Route::put('/restaurants/{restaurant}', [RestaurantsController::class, 'suspend'])->name('restaurants.suspend');
        Route::put('/payment_method/{accounting}', [PaymentMethodController::class, 'suspend'])->name('payment_method.suspend');
        Route::put('/users/{user}', [UsersController::class, 'suspend'])->name('users.suspend');
        Route::put('/business/{business}', [BusinessController::class, 'suspend'])->name('business.suspend');
    });

    Route::prefix('fetch')->group(function () {
        Route::get('/categories', [FetchDataController::class, 'getCategories'])->name('categories.get');
        Route::get('/subcategories/{id}', [FetchDataController::class, 'getSubcategories'])->name('subcategories.get');
        // Route::get('/restaurants/{id}', [FetchDataController::class, 'getRestaurants'])->name('restaurants.get');
        Route::post('/restaurants', [FetchDataController::class, 'getRestaurants'])->name('restaurants.get');
        Route::get('roles/', [FetchDataController::class, 'getRoles'])->name('roles.get');
        Route::get('permissions/', [FetchDataController::class, 'getPermissions'])->name('permissions.get');
    });

    Route::prefix('{business:slug}')->name('business.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('projections', ProjectionController::class);
        Route::get('/monthly', [ProjectionController::class, 'getProjectionsMonthly'])->name('projections_monthly.get');
        // Route::resource('providers', ProvidersController::class);
        Route::resource('invoices', InvoicesController::class);
        Route::resource('payment_method', PaymentMethodController::class);
        Route::resource('expenses_categories', ExpensesCategoriesController::class);
        Route::resource('expenses', ExpensesController::class);

        Route::prefix('{restaurants:slug}')->name('restaurants.')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::resource('home', HomeController::class);
            // Rutas normales de projections
            Route::resource('projections', ProjectionController::class);
            // Ruta simplificada para proyecciones mensuales
            Route::prefix('projections/{month}')->name('projections.month.')->group(function () {
                Route::resource('monthly', ProjectionDayController::class);
                Route::get('sales_get', [ProjectionDayController::class,'sales_get'])->name('sales.get');
                Route::put('sales_update', [ProjectionDayController::class, 'sales_update'])->name('sales.update');
            });
            Route::resource('providers', ProvidersController::class);
            Route::resource('typeproviders', TypeProvidersController::class);
            Route::resource('invoices', InvoicesController::class);
            Route::resource('payment_method', PaymentMethodController::class);
            Route::resource('expenses_categories', ExpensesCategoriesController::class);
            Route::resource('expenses', ExpensesController::class);
            Route::resource('payroll', PayrollController::class);
            Route::resource('employees', EmployeesController::class);
                
                Route::put('employees/{employee}/suspend', [EmployeesController::class, 'suspend'])->name('employees.suspend');
                Route::put('employees/{employee}/restore', [EmployeesController::class, 'restore'])->name('employees.restore');
                Route::delete('employees/{employee}/destroy', [EmployeesController::class, 'destroy'])->name('employees.destroy');
            Route::resource('positions', PositionsController::class);
                Route::put('positions/{position}/suspend', [PositionsController::class, 'suspend'])->name('positions.suspend');
                Route::put('positions/{position}/restore', [PositionsController::class, 'restore'])->name('positions.restore');
                Route::delete('positions/{position}/destroy', [PositionsController::class, 'destroy'])->name('positions.destroy');
            Route::resource('payroll_periods', PayrollPeriodsController::class);
            Route::resource('attendance', AttendanceRecordsController::class);

            Route::prefix('suspend')->group(function () {
                Route::put('/providers/{providers}', [ProvidersController::class, 'suspend'])->name('providers.suspend');
            });

        });

    });
});

require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ChequesController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ExpensesCategoriesController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\FetchDataController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvidersController;
use App\Http\Controllers\RestaurantsController;
use App\Http\Controllers\RolesPermissionsController;
use App\Http\Controllers\UsersController;
use App\Models\Business;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UsersController::class);
    Route::resource('business', BusinessController::class);
    Route::resource('restaurants', RestaurantsController::class);
    Route::resource('providers', ProvidersController::class);
    Route::resource('expenses_categories', ExpensesCategoriesController::class);
    Route::resource('expenses', ExpensesController::class);
    Route::resource('payment_method', PaymentMethodController::class);
    Route::resource('cheques', ChequesController::class);
    Route::resource('invoices', InvoicesController::class);
    Route::resource('roles_permissions', RolesPermissionsController::class);

    Route::prefix('restore')->group( function(){
        Route::put('/restaurants/{restaurant}', [RestaurantsController::class, 'restore'])->name('restaurants.restore');
        Route::put('/payment_method/{accounting}', [PaymentMethodController::class, 'restore' ])->name('payment_method.restore');
        Route::put('/users/{user}', [UsersController::class, 'restore' ])->name('users.restore');
        Route::put('/business/{business}', [BusinessController::class, 'restore' ])->name('business.restore');

    });
    Route::prefix('suspend')->group( function(){
        Route::put('/restaurants/{restaurant}', [RestaurantsController::class, 'suspend' ])->name('restaurants.suspend');
        Route::put('/payment_method/{accounting}', [PaymentMethodController::class, 'suspend' ])->name('payment_method.suspend');
        Route::put('/users/{user}', [UsersController::class, 'suspend' ])->name('users.suspend');
        Route::put('/business/{business}', [BusinessController::class, 'suspend' ])->name('business.suspend');
    });

    Route::prefix('fetch')->group( function(){
        Route::get('/categories', [FetchDataController::class, 'getCategories'])->name('categories.get');
        Route::get('/subcategories/{id}', [FetchDataController::class, 'getSubcategories'])->name('subcategories.get');
        Route::get('/restaurants/{id}', [FetchDataController::class, 'getRestaurants'])->name('restaurants.get');
        Route::get('roles/', [FetchDataController::class, 'getRoles'])->name('roles.get');
        Route::get('permissions/', [FetchDataController::class, 'getPermissions'])->name('permissions.get');
    });

    Route::domain('blog.' . env('APP_URL'))->group(function () {
        Route::get('posts', function () {
            return 'Tu subdominio';
        });
    });

});

require __DIR__.'/auth.php';    

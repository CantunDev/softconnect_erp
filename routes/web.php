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
use App\Http\Controllers\UsersController;
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

    Route::prefix('restore')->group( function(){
        Route::get('/restaurants/{restaurant}', [RestaurantsController::class, 'restore'])->name('restaurants.restore');
        Route::put('/payment_method/{accounting}', [PaymentMethodController::class, 'restore' ])->name('payment_method.restore');

    });
    Route::prefix('suspend')->group( function(){
        Route::delete('/restaurants/{restaurant}', [RestaurantsController::class, 'suspend' ])->name('restaurants.suspend');
        Route::put('/payment_method/{accounting}', [PaymentMethodController::class, 'suspend' ])->name('payment_method.suspend');
        
    });
    // Route::group(['prefix' => 'cheques'], function(){
    //     Route::post('putget/{ip}/{database}/{table}', ChequesController::class, 'get')->name('cheques.get');
    // });
    // Route::get('/categories', [ExpensesCategoriesController::class, 'getCategories'])->name('categories.get');
    // Route::get('/subcategories/{id}', [ExpensesCategoriesController::class, 'getSubcategories'])->name('subcategories.get');

    // Route::post('/fetch-subcategories', [ExpensesController::class, 'fetchSubcategories'])->name('fetch.subcategories');
    // Route::post('/fetch-subsubcategories', [ExpensesController::class, 'fetchSubsubcategories'])->name('fetch.subsubcategories');

    // Route::get('connection/{ip}/{database}/{table}', [ConnectionSQLController::class, 'connection'])->name('connectionsqlsrv');
    Route::prefix('fetch')->group( function(){
        Route::get('/categories', [FetchDataController::class, 'getCategories'])->name('categories.get');
        Route::get('/subcategories/{id}', [FetchDataController::class, 'getSubcategories'])->name('subcategories.get');
        Route::get('/restaurantes/{id}', [FetchDataController::class, 'getRestaurantes'])->name('restaurantes.get');

    });

});

require __DIR__.'/auth.php';    

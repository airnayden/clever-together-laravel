<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Routes for `Customer` management
Route::group(['prefix' => 'customer'], function(Router $route) {
    $route->get('', [CustomerController::class, 'index'])->name('customer.index');
    $route->get('{customer_id}', [CustomerController::class, 'show'])->name('customer.show');
    $route->post('', [CustomerController::class, 'store'])->name('customer.store');
    $route->put('{customer_id}', [CustomerController::class, 'update'])->name('customer.update');
    $route->delete('{customer_id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
});

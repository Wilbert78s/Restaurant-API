<?php

use App\Models\Vendor;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\TransactionController;

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

Route::get('/doc', function () {
    return view('welcome');
});

// tambah vendor
Route::post('/vendor', [VendorController::class, 'addVendor']);

// tambah transaksi yang dilakukan vendor
Route::post('/vendor/transaction', [VendorController::class, 'addTransaction']);

// tambah customer
Route::post('/customer', [CustomerController::class, 'addCustomer']);

// tambah transaksi yang dilakukan customer
Route::post('/customer/transaction', [CustomerController::class, 'addTransaction']);



// lihat list vendor
Route::get('/vendor', [VendorController::class, 'show']);

// lihat transaksi yang dilakukan vendor
Route::get('/vendor/transaction', [VendorController::class, 'showVendorTransaction']);

// lihat transaksi yang dilakukan vendor spesifik
Route::get('/vendor/transaction/{vendor:id}', [VendorController::class, 'showTransaction']);

// lihat detail transaksi vendor
Route::get('/vendor/transaction/detail/{vendorTransaction:id}', [VendorController::class, 'showDetailTransaction']);


// lihat list customer
Route::get('/customer', [CustomerController::class, 'show']);

// lihat transaksi yang dilakukan customer
Route::get('/customer/transaction/', [CustomerController::class, 'showCustomerTransaction']);

// lihat transaksi yang dilakukan customer specific
Route::get('/customer/transaction/{customer:id}', [CustomerController::class, 'showTransaction']);

// lihat detail transaksi customer
Route::get('/customer/transaction/detail/{customerTransaction:id}', [CustomerController::class, 'showDetailTransaction']);


// lihat cash restaurant
Route::get('/restaurant/cash', [RestaurantController::class, 'showCash']);

// lihat list menu
Route::get('/restaurant/menu', [RestaurantController::class, 'showMenu']);

// lihat resep dari 1 menu spesifik
Route::get('/restaurant/recipe/{menu:id}', [RestaurantController::class, 'showRecipe']);

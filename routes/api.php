<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\WarehouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//auth
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//company
Route::get('/company', [CompanyController::class, 'show']);
Route::put('/company', [CompanyController::class, 'update']);

//INVENTORY
//categories
Route::apiResource('/categories', App\Http\Controllers\Api\Inventory\CategoryController::class)->middleware('auth:sanctum');
//category update with post
Route::post('/categories/{id}', [App\Http\Controllers\Api\Inventory\CategoryController::class, 'update'])->middleware('auth:sanctum');

//brands
Route::apiResource('/brands', App\Http\Controllers\Api\Inventory\BrandController::class)->middleware('auth:sanctum');

//brand update with post
Route::post('/brands/{id}', [App\Http\Controllers\Api\Inventory\BrandController::class, 'update'])->middleware('auth:sanctum');

//units
Route::apiResource('/units', App\Http\Controllers\Api\Inventory\UnitController::class)->middleware('auth:sanctum');

//warehouses
//warehouse
Route::apiResource('/warehouses', WarehouseController::class)->middleware('auth:sanctum');

//suppliers
Route::apiResource('/suppliers', App\Http\Controllers\Api\Inventory\SupplierController::class)->middleware('auth:sanctum');

//products
Route::apiResource('/products', App\Http\Controllers\Api\Inventory\ProductController::class)->middleware('auth:sanctum');

// post update product
Route::post('/products/{id}', [App\Http\Controllers\Api\Inventory\ProductController::class, 'update'])->middleware('auth:sanctum');

//create customer
Route::post('/create-customer', [App\Http\Controllers\Api\Pos\UserController::class, 'createCustomer'])->middleware('auth:sanctum');

//get customer
Route::get('/get-customer', [App\Http\Controllers\Api\Pos\UserController::class, 'getCustomer'])->middleware('auth:sanctum');

// order draft
Route::post('/draft-order', [App\Http\Controllers\Api\Pos\DraftOrderController::class, 'store'])->middleware('auth:sanctum');

//get draft order
Route::get('/draft-order', [App\Http\Controllers\Api\Pos\DraftOrderController::class, 'index'])->middleware('auth:sanctum');

//show draft order
Route::get('/draft-order/{id}', [App\Http\Controllers\Api\Pos\DraftOrderController::class, 'show'])->middleware('auth:sanctum');

//update draft order
Route::put('/draft-order/{id}', [App\Http\Controllers\Api\Pos\DraftOrderController::class, 'update'])->middleware('auth:sanctum');

//order
Route::post('/order', [App\Http\Controllers\Api\Pos\OrderController::class, 'store'])->middleware('auth:sanctum');

//get order
Route::get('/order', [App\Http\Controllers\Api\Pos\OrderController::class, 'index'])->middleware('auth:sanctum');

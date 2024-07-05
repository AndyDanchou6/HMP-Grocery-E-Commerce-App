<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SelectedItemsController;
use App\Http\Controllers\ShopController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/selectedItems/count', [SelectedItemsController::class, 'packageCount'])->name('selectedItems.count');
Route::get('/selectedItems/notify', [SelectedItemsController::class, 'notification'])->name('selectedItems.notification')->middleware('web');
Route::get('/test', [ShopController::class, 'test']);
// Route::controller(AdminController::class)->group(function () {
//     Route::post('/login', 'login');
//     Route::post('/register', 'register');
//     Route::get('userAllData', 'getAllData');
//     Route::get('/getUserData/{id}', 'getData');
//     Route::post('/updateUserData/{id}', 'update');
//     Route::delete('/user/{id}', 'destroy');
//     Route::get('/profile', 'profile')->middleware('auth:sanctum');
// });

// Route::controller(InventoryController::class)->group(function () {
//     Route::post('inventory', 'store');
//     Route::get('inventoryAllData', 'getAllData');
//     Route::get('/getInventoryData/{id}', 'getData');
//     Route::delete('/inventory/{id}', 'destroy');
//     Route::post('/updateInventoryData/{id}', 'update');
// });

// Route::controller(CategoryController::class)->group(function () {
//     Route::post('category', 'store');
//     Route::get('categoryAllData', 'getAllData');
//     Route::get('/getCategoryData/{id}', 'getData');
//     Route::delete('/category/{id}', 'destroy');
//     Route::post('/updateCategoryData/{id}', 'update');
// });

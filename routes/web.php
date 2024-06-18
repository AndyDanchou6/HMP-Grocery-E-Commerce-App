<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SelectedItemsController;
use App\Http\Controllers\shopController;
use App\Models\Category;
use App\Models\SelectedItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landingPage');
})->name('welcome');

Route::get('/test-select', function () {
    $pickup1 = \App\Models\SelectedItems::create([
        'referenceNo' => 110000,
        'user_id' => 1,
        'item_id' => 1,
        'status' => 'forPackage',
        'quantity' => 4,
        'order_retrieval' => 'pickup'
    ]);

    $pickup2 = \App\Models\SelectedItems::create([
        'referenceNo' => 110000,
        'user_id' => 1,
        'item_id' => 2,
        'status' => 'forPackage',
        'quantity' => 6,
        'order_retrieval' => 'pickup'
    ]);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/error', [AuthController::class, 'error'])->name('error');

Route::get('/error404', [AuthController::class, 'error404'])->name('error404');

Route::resource('categories', CategoryController::class);

Route::resource('inventories', InventoryController::class);

Route::resource('users', AdminController::class)->middleware('admin');

Route::resource('profile', ProfileController::class);

// Route::resource('selectedItems', SelectedItemsController::class);

Route::resource('reviews', ReviewController::class);

Route::get('/shop', [shopController::class, 'index'])->name('shop.index');
Route::get('/shop/products', [shopController::class, 'shop'])->name('shop.products');
Route::get('/shop/products/details/{id}', [shopController::class, 'details'])->name('shop.details');

Route::get('/selectedItems/forPackaging', [SelectedItemsController::class, 'forPackaging'])->name('selectedItems.forPackaging');
Route::get('/selectedItems/forDelivery', [SelectedItemsController::class, 'forDelivery'])->name('selectedItems.forDelivery');
Route::get('/selectedItems/forPickup', [SelectedItemsController::class, 'forPickup'])->name('selectedItems.forPickup');
Route::post('/selected-items/{referenceNo}/update', [SelectedItemsController::class, 'update'])->name('selected-items.update');

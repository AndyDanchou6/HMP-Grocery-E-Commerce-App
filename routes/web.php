<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeliveryScheduleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SelectedItemsController;
use App\Http\Controllers\ShopController;
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
    // $pickup1 = \App\Models\SelectedItems::create([
    //     'referenceNo' => rand(10000000, 99999999),
    //     'user_id' => 1,
    //     'item_id' => 1,
    //     'status' => 'forPackage',
    //     'quantity' => 4,
    //     'order_retrieval' => 'pickup'
    // ]);

    // $pickup2 = \App\Models\SelectedItems::create([
    //     'referenceNo' => rand(10000000, 99999999),
    //     'user_id' => 1,
    //     'item_id' => 3,
    //     'status' => 'forPackage',
    //     'quantity' => 6,
    //     'order_retrieval' => 'pickup'
    // ]);


    $cart1 = \App\Models\Cart::create([
        'user_id' => 1,
        'product_id' => rand(1, 20),
        'quantity' => rand(5, 10),
    ]);

    $cart2 = \App\Models\Cart::create([
        'user_id' => 3,
        'product_id' => rand(1, 20),
        'quantity' => rand(5, 10),
    ]);
});

Auth::routes();

// Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.home');
});

Route::prefix('customer')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('customer.home');
});

Route::prefix('courier')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('courier.home');
});

Route::get('/error', [AuthController::class, 'error'])->name('error');

Route::get('/error404', [AuthController::class, 'error404'])->name('error404');

Route::resource('admin/categories', CategoryController::class);

Route::resource('admin/inventories', InventoryController::class);

Route::resource('admin/users', AdminController::class)->middleware('admin');

Route::resource('profile', ProfileController::class);

// Route::resource('selectedItems', SelectedItemsController::class);

Route::resource('reviews', ReviewController::class);

Route::resource('carts', CartController::class);

Route::post('/carts/checkout', [CartController::class, 'checkout'])->name('carts.checkout');
Route::post('/carts/update', [CartController::class, 'update'])->name('carts.updateQty');
Route::delete('/carts/deleteAll/{id}', [CartController::class, 'destroyAll'])->name('carts.destroyAll');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/carts', [ShopController::class, 'carts'])->name('shop.carts');
Route::get('/shop/products', [ShopController::class, 'shop'])->name('shop.products');
Route::get('/shop/products/details/{id}', [ShopController::class, 'details'])->name('shop.details');
Route::get('/shop/products/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');
Route::post('/shop/products/placeOrder', [ShopController::class, 'placeOrder'])->name('shop.placeOrder');
Route::post('/shop/products/cancelCheckout', [ShopController::class, 'cancelCheckout'])->name('shop.cancelCheckout');
Route::post('/shop/products/buynow', [ShopController::class, 'buyNow'])->name('shop.buyNow');

Route::get('/admin/selectedItems/forPackaging', [SelectedItemsController::class, 'forPackaging'])->name('selectedItems.forPackaging');
Route::get('/courier/selectedItems/deliveryRequest', [SelectedItemsController::class, 'courierDashboard'])->name('selectedItems.courierDashboard');
Route::get('/customer/selectedItems/orders', [SelectedItemsController::class, 'orders'])->name('selectedItems.orders');
Route::get('/admin/selectedItems/forDelivery', [SelectedItemsController::class, 'forDelivery'])->name('selectedItems.forDelivery');
Route::get('/admin/selectedItems/forPickup', [SelectedItemsController::class, 'forPickup'])->name('selectedItems.forPickup');
Route::get('/admin/selectedItems/deniedOrders', [SelectedItemsController::class, 'deniedOrders'])->name('selectedItems.deniedOrders');
Route::post('/selected-items/{referenceNo}/update', [SelectedItemsController::class, 'updateStatus'])->name('selected-items.update');
Route::post('/selected-items/{referenceNo}/updatePaymentCondition', [SelectedItemsController::class, 'updatePaymentCondition'])->name('selected-items.updatePaymentCondition');
Route::get('/admin/selectedItems/history', [SelectedItemsController::class, 'show'])->name('selectedItems.history');

Route::get('/check', [SelectedItemsController::class, 'forCheckout']);


//--- Delivery Schedules ----!>
Route::get('admin/schedules', [DeliveryScheduleController::class, 'index'])->name('schedules.index');
Route::post('admin/schedules/create', [DeliveryScheduleController::class, 'store'])->name('schedules.store');
Route::delete('admin/schedules/{schedule}', [DeliveryScheduleController::class, 'destroy'])->name('schedules.destroy');
Route::put('admin/schedules/{schedule}', [DeliveryScheduleController::class, 'update'])->name('schedules.update');

Route::get('/showMorning', [SelectedItemsController::class, 'showMorning']);

Route::middleware('auth')->get('/selectedItems/courierCount', [SelectedItemsController::class, 'courierTask'])->name('selectedItems.courierCount');

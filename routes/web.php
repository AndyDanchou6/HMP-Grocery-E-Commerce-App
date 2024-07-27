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
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceFeeController;
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

Auth::routes();

// Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.home');
});

Route::prefix('customer')->middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AuthController::class, 'customerDashboard'])->name('customer.home');
});

Route::prefix('courier')->middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AuthController::class, 'courierDashboard'])->name('courier.home');
});

Route::middleware('auth')->group(function () {
    Route::get('/error', [AuthController::class, 'error'])->name('error');
    Route::get('/error404', [AuthController::class, 'error404'])->name('error404');
    Route::resource('profile', ProfileController::class);
    Route::resource('admin/users', AdminController::class)->middleware('admin');
    Route::resource('reviews', ReviewController::class);
    Route::resource('carts', CartController::class);
    Route::post('/carts/checkout', [CartController::class, 'checkout'])->name('carts.checkout');
    Route::post('/carts/update', [CartController::class, 'update'])->name('carts.updateQty');
    Route::delete('/carts/deleteAll/{id}', [CartController::class, 'destroyAll'])->name('carts.destroyAll');
});

Route::middleware('auth')->group(function () {
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/shop/carts', [ShopController::class, 'carts'])->name('shop.carts');
    Route::get('/shop/products', [ShopController::class, 'shop'])->name('shop.products');
    Route::get('/shop/products/details/{id}', [ShopController::class, 'details'])->name('shop.details');
    Route::get('/shop/products/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');
    Route::post('/shop/products/placeOrder', [ShopController::class, 'placeOrder'])->name('shop.placeOrder');
    Route::post('/shop/products/cancelCheckout', [ShopController::class, 'cancelCheckout'])->name('shop.cancelCheckout');
    Route::post('/shop/products/buynow', [ShopController::class, 'buyNow'])->name('shop.buyNow');
    Route::get('/shop/check/checkOrders', [ShopController::class, 'countOrders'])->name('shop.count');
});

Route::get('/courier/selectedItems/deliveryRequest', [SelectedItemsController::class, 'courierDashboard'])->name('selectedItems.courierDashboard');

//--- Admin Route Section ----!>
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('inventories', InventoryController::class);
    Route::get('selectedItems/forPackaging', [SelectedItemsController::class, 'forPackaging'])->name('selectedItems.forPackaging');
    Route::get('selectedItems/forDelivery', [SelectedItemsController::class, 'forDelivery'])->name('selectedItems.forDelivery');
    Route::get('selectedItems/forPickup', [SelectedItemsController::class, 'forPickup'])->name('selectedItems.forPickup');
    Route::get('selectedItems/deniedOrders', [SelectedItemsController::class, 'deniedOrders'])->name('selectedItems.deniedOrders');
    Route::post('selected-items/{referenceNo}/update', [SelectedItemsController::class, 'updateStatus'])->name('selected-items.update');
    Route::post('selected-items/{referenceNo}/updatePaymentCondition', [SelectedItemsController::class, 'updatePaymentCondition'])->name('selected-items.updatePaymentCondition');
    Route::get('selectedItems/history', [SelectedItemsController::class, 'show'])->name('selectedItems.history');

    Route::get('selectedItems/forGcashPayments', [SelectedItemsController::class, 'forGcashPayments'])->name('selectedItems.forGcashPayments');
    Route::get('selectedItems/forCODPayments', [SelectedItemsController::class, 'forCODPayments'])->name('selectedItems.forCODPayments');
    Route::get('selectedItems/forInStorePayments', [SelectedItemsController::class, 'forInStorePayments'])->name('selectedItems.forInStorePayments');
    Route::get('selectedItems/generate-report', [SelectedItemsController::class, 'generateReport'])->name('generate-invoice');

    //--- Delivery Schedules ----!>
    Route::get('schedules', [DeliveryScheduleController::class, 'index'])->name('schedules.index');
    Route::post('schedules/create', [DeliveryScheduleController::class, 'store'])->name('schedules.store');
    Route::delete('schedules/{schedule}', [DeliveryScheduleController::class, 'destroy'])->name('schedules.destroy');
    Route::put('schedules/{schedule}', [DeliveryScheduleController::class, 'update'])->name('schedules.update');
});

Route::get('/check', [SelectedItemsController::class, 'forCheckout']);

Route::get('/showMorning', [SelectedItemsController::class, 'showMorning']);
Route::get('/availableStocks', [InventoryController::class, 'availableStocks']);
Route::get('/productByName', [InventoryController::class, 'test']);
Route::post('/addAsVariant', [InventoryController::class, 'addAsVariant']);
Route::put('restock/{itemId}', [InventoryController::class, 'restock'])->name('inventories.restock');

Route::middleware('auth')->get('/selectedItems/courierCount', [SelectedItemsController::class, 'courierTask'])->name('selectedItems.courierCount');

// Service Fee
Route::get('admin/service_fee', [ServiceFeeController::class, 'index'])->name('serviceFee.index');
Route::post('admin/service_fee/create', [ServiceFeeController::class, 'store'])->name('serviceFee.store');
Route::put('admin/service_fee/{serviceFee}', [ServiceFeeController::class, 'update'])->name('serviceFee.update');
Route::delete('admin/service_fee/{serviceFee}', [ServiceFeeController::class, 'destroy'])->name('serviceFee.destroy');

/* Customers Route Section */
Route::prefix('customer')->middleware('auth')->group(function () {
    Route::get('selectedItems/countOrders', [CustomerController::class, 'orderCount'])->name('customers.countOrders');
    Route::get('selectedItems/orders', [CustomerController::class, 'orders'])->name('customers.orders');
    Route::get('orders/pendingOrders', [CustomerController::class, 'forPendingOrders'])->name('customers.pending_orders');
    Route::get('orders/deliveryRetrieval', [CustomerController::class, 'forDeliveryRetrieval'])->name('customers.delivery_retrieval');
    Route::get('orders/pickupRetrieval', [CustomerController::class, 'forPickupRetrieval'])->name('customers.pickup_retrieval');
    Route::get('orders/unpaidOrders', [CustomerController::class, 'forUnpaidOrders'])->name('customers.unpaid_orders');
    Route::get('orders/notification', [CustomerController::class, 'notificationUpdates'])->name('customers.userNotification');
});


// Change password
Route::post('changePass', [ProfileController::class, 'changePass'])->name('profile.changePass');

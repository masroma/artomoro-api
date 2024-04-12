<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Route API Auth
 */
Route::post('/login', [AuthController::class, 'login'])->name('api.customer.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.customer.register');
Route::get('/user', [AuthController::class, 'getUser'])->name('api.customer.user');
Route::get('/refreshtoken', [AuthController::class, 'refreshToken'])->name('api.customer.refreshtoken');
Route::post('/updateprofile', [AuthController::class, 'updateProfile'])->name('api.customer.updateprofile');

Route::post('/updatepassword', [AuthController::class, 'updatePassword'])->name('api.customer.updatepassword');

/**
 * Router Order
 */
Route::get('/order', [OrderController::class, 'index'])->name('api.order.index');
Route::get('/order/{snap_token?}', [OrderController::class, 'show'])->name('api.order.show');

/**
 * Route API Category
 */
Route::get('/categories', [CategoryController::class, 'index'])->name('customer.category.index');
Route::get('/category/{slug?}', [CategoryController::class, 'show'])->name('customer.category.show');
Route::get('/categoryHeader', [CategoryController::class, 'categoryHeader'])->name('customer.category.categoryHeader');

/**
 * Route API Product
 */
Route::get('/products', [ProductController::class, 'index'])->name('customer.product.index');
Route::get('/product/{slug?}', [ProductController::class, 'show'])->name('customer.product.show');

/**
 * Route API Cart
 */
Route::get('/metodepembayaran', [MetodePembayaranController::class, 'index'])->name('customer.metodepembayaran.index');
Route::get('/cart', [CartController::class, 'index'])->name('customer.cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('customer.cart.store');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('customer.cart.update');
Route::get('/cart/total', [CartController::class, 'getCartTotal'])->name('customer.cart.total');
Route::get('/cart/totalWeight', [CartController::class, 'getCartTotalWeight'])->name('customer.cart.getCartTotalWeight');
Route::post('/cart/remove', [CartController::class, 'removeCart'])->name('customer.cart.remove');
Route::post('/cart/removeAll', [CartController::class, 'removeAllCart'])->name('customer.cart.removeAll');

/**
 * Route Raja Ongkir
 */
Route::get('/rajaongkir/provinces', [RajaOngkirController::class, 'getProvinces'])->name('customer.rajaongkir.getProvinces');
Route::get('/rajaongkir/cities', [RajaOngkirController::class, 'getCities'])->name('customer.rajaongkir.getCities');
Route::post('/rajaongkir/checkOngkir', [RajaOngkirController::class, 'checkOngkir'])->name('customer.rajaongkir.checkOngkir');

/**
 * Route Checkout
 */
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::post('/notificationHandler', [CheckoutController::class, 'notificationHandler'])->name('notificationHanlder');

/**
 * Route API Slider
 */
Route::get('/sliders', [SliderController::class, 'index'])->name('customer.slider.index');


Route::prefix('api-admin')->group(function () {

    //route login
    Route::post('/login', [AuthAdminController::class, 'index', ['as' => 'admin']]);

    //group route with middleware "auth:api_admin"
    Route::group(['middleware' => 'auth:api_admin'], function() {

        //data user
        Route::get('/user', [AuthAdminController::class, 'getUser', ['as' => 'admin']]);

        //refresh token JWT
        Route::get('/refresh', [AuthAdminController::class, 'refreshToken', ['as' => 'admin']]);

        //logout
        Route::post('/logout', [AuthAdminController::class, 'logout', ['as' => 'admin']]);


        Route::get('/order', [OrderAdminController::class, 'index'])->name('admin.order.index');
        Route::get('/omsetkemarin', [OrderAdminController::class, 'omsetKemarin'])->name('admin.omsetkemarin.index');
        Route::get('/omsethariini', [OrderAdminController::class, 'omsetHariIni'])->name('admin.omsethariini.index');
        Route::get('/omsetbulanini', [OrderAdminController::class, 'omsetSatuBulanIni'])->name('admin.omsetbulanini.index');
        Route::get('/cart', [CartAdminController::class, 'index'])->name('admin.cart.index');
        Route::post('/cart', [CartAdminController::class, 'store'])->name('admin.cart.store');
        Route::post('/cart/update/{id}', [CartAdminController::class, 'update'])->name('admin.cart.update');
        Route::get('/cart/total', [CartAdminController::class, 'getCartTotal'])->name('admin.cart.total');
        Route::get('/cart/totalWeight', [CartAdminController::class, 'getCartTotalWeight'])->name('admin.cart.getCartTotalWeight');
        Route::post('/cart/remove', [CartAdminController::class, 'removeCart'])->name('admin.cart.remove');
        Route::post('/cart/removeAll', [CartAdminController::class, 'removeAllCart'])->name('admin.cart.removeAll');
        Route::post('/checkout', [CheckoutAdminController::class, 'store'])->name('admin.checkout.store');
    });

});

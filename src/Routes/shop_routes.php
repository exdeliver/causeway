<?php
/**
 * Public shop routes
 */

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'shop', 'namespace' => 'Shop'], function () {
    Route::get('/', 'ShopController@index')->name('shop.index');

    Route::post('/product/add-to-cart', 'CartController@addProduct')->name('shop.product.add_to_cart');

    Route::get('/cart', 'ShopController@getCart')->name('shop.cart');

    Route::get('/cart-details', 'CartController@index')->name('shop.cart.details');

    Route::post('/cart', 'CartController@cart')->name('shop.cart.order');

    Route::get('/cart/clear', 'CartController@clear')->name('shop.cart.clear');

    Route::get('/checkout', 'ShopController@getCheckout')->name('shop.checkout');

    Route::post('/checkout', 'OrderController@process')->name('shop.checkout.store');

    Route::get('/order/status/{orderUuid}', 'OrderController@status')->name('shop.order.status');

    Route::get('/order/pay/{orderUuid}', 'OrderController@paymentRedirect')->name('shop.order.pay');

    Route::get('/order/invoice/{orderUuid}', 'OrderController@invoice')->name('shop.order.invoice');

    Route::post('/couponcode', 'CartController@couponcode')->name('shop.couponcode.store');

    Route::get('/product/{shopProductSlug}', 'ShopController@getProduct')->name('shop.product');

    Route::get('/category/{shopCategorySlug}', 'ShopController@getCategory')->name('shop.category');

    Route::group(['prefix' => 'account'], function () {
        Route::get('orders', 'ShopController@getOrders')->name('shop.account.orders');
    });
});

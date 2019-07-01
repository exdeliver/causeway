<?php

/**
 * Admin shop routes
 * Prefix: causeway/shop
 */
Route::group(['prefix' => 'shop', 'namespace' => 'Shop'], function () {
    /**
     * Prefix: causeway/shop/ajax
     */
    Route::group(['prefix' => 'ajax'], function () {
        /**
         * Prefix: causeway/shop/ajax/category
         */
        Route::group(['prefix' => 'category'], function () {
            Route::get('index', 'CategoryController@getAjaxCategories')->name('ajax.shop.category.index');
        });

        /**
         * Prefix: causeway/shop/ajax/product
         */
        Route::group(['prefix' => 'product'], function () {
            Route::get('index', 'ProductController@getAjaxProducts')->name('ajax.shop.product.index');
        });

        /**
         * Prefix: causeway/shop/ajax/customer
         */
        Route::group(['prefix' => 'customer'], function () {
            Route::get('index', 'CustomerController@getAjaxCustomers')->name('ajax.shop.customer.index');
        });

        /**
         * Prefix: causeway/shop/ajax/order
         */
        Route::group(['prefix' => 'order'], function () {
            Route::get('index', 'OrderController@getAjaxOrders')->name('ajax.shop.orders.index');
        });

        /**
         * Prefix: causeway/shop/ajax/couponcode
         */
        Route::group(['prefix' => 'couponcode'], function () {
            Route::get('index', 'CouponCodeController@getAjaxCouponCodes')->name('ajax.shop.couponcode.index');
        });
    });

    Route::get('/dashboard', 'DashboardController@index')->name('admin.shop.dashboard');

    Route::post('order/status/{orderId}', 'OrderController@status')->name('admin.shop.order.status');

    Route::resource('order', 'OrderController')->names([
        'index' => 'admin.shop.order.index',
        'create' => 'admin.shop.order.create',
        'edit' => 'admin.shop.order.update',
        'show' => 'admin.shop.order.show',
        'store' => 'admin.shop.order.new.store',
        'update' => 'admin.shop.order.update.store',
        'destroy' => 'admin.shop.order.destroy',
    ]);

    Route::resource('product', 'ProductController')->names([
        'index' => 'admin.shop.product.index',
        'create' => 'admin.shop.product.create',
        'edit' => 'admin.shop.product.update',
        'store' => 'admin.shop.product.new.store',
        'update' => 'admin.shop.product.update.store',
        'destroy' => 'admin.shop.product.destroy',
    ]);

    Route::resource('category', 'CategoryController')->names([
        'index' => 'admin.shop.category.index',
        'create' => 'admin.shop.category.create',
        'edit' => 'admin.shop.category.update',
        'store' => 'admin.shop.category.new.store',
        'update' => 'admin.shop.category.update.store',
        'destroy' => 'admin.shop.category.destroy',
    ]);
    Route::get('category/index/sort', 'CategoryController@sortCategory')->name('admin.shop.category.index.sort');

    Route::resource('customer', 'CustomerController')->names([
        'index' => 'admin.shop.customer.index',
        'create' => 'admin.shop.customer.create',
        'edit' => 'admin.shop.customer.update',
        'store' => 'admin.shop.customer.new.store',
        'update' => 'admin.shop.customer.update.store',
        'destroy' => 'admin.shop.customer.destroy',
    ]);

    Route::resource('couponcode', 'CouponCodeController')->names([
        'index' => 'admin.shop.couponcode.index',
        'create' => 'admin.shop.couponcode.create',
        'edit' => 'admin.shop.couponcode.update',
        'store' => 'admin.shop.couponcode.new.store',
        'update' => 'admin.shop.couponcode.update.store',
        'destroy' => 'admin.shop.couponcode.destroy',
    ]);
});
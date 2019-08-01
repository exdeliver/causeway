<?php
/**
 * Api routes.
 */
Route::post('/causeway/mollie-payment', 'Api\V1\ApiController@payment')->name('api.mollie-payment');

Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1', 'middleware' => ['client_credentials']], function () {
});

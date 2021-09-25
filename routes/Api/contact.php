<?php

use Illuminate\Support\Facades\Route;


Route::namespace('App\Http\Controllers\API\Contact')->middleware('cors')->prefix('contact-espace/auth')->name('auth.')->group(function () {
    Route::post('login', 'AuthController@login');
});

Route::namespace('App\\Http\\Controllers\\API\Contact')->middleware(['cors', 'auth:contact-api'])->prefix('contact-espace')->group(function () {
    Route::get('order/list', 'OrderController@index');
    Route::get('order/historique', 'OrderController@historique');
    Route::get('order/refresh', 'OrderController@refresh');
    Route::get('order-reportie', 'OrderController@getOrderReportie');
    Route::post('order/import', 'OrderController@import');
    Route::get('auth/verify', 'AuthController@verify');
    Route::post('update-info', 'AuthController@updateInfo');
    Route::get('get-info', 'AuthController@getInfo');
    Route::put('order-relancer/{id}', 'OrderController@relancerOrder');
    Route::put('order/status-livreur/{id}', 'OrderController@updateStatusLivreur');
    Route::get('order/status/{status}/{city:id}', 'OrderController@index');

    Route::apiResources([
        'orderStatus'   => 'OrderStatusController',
        'order'         => 'OrderController',
        'country'       => 'CityController',
        'product'       => 'ProductController',
        'livreurStatus' => 'LivreurStatusController',
        'contact'       => 'ContactController',
    ]);
});

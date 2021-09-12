<?php
use Illuminate\Support\Facades\Route;


Route::namespace('App\Http\Controllers\API\Gestion')->middleware('cors')->prefix('gestion-espace/auth')->name('auth.')->group(function () {
    Route::post('login', 'AuthController@login');
});

Route::namespace('App\\Http\\Controllers\\API\Gestion')->middleware(['cors','auth:gestion-api'])->prefix('gestion-espace')->group(function () {
    Route::get('order/list', 'OrderController@index');
    Route::get('order/historique', 'OrderController@historique');
    Route::get('order/refresh', 'OrderController@refresh');
    Route::get('consumers/list', 'ConsumerController@list');
    Route::get('products/list/{contact:id}', 'ProductController@list');
    Route::get('auth/verify', 'AuthController@verify');
    Route::post('update-info', 'AuthController@updateInfo');
    Route::get('get-info', 'AuthController@getInfo');
    Route::apiResources([
        'orderStatus'   => 'OrderStatusController',
        'order'         => 'OrderController',
        'country'       => 'CityController',
    ]);
});

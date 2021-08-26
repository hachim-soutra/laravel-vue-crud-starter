<?php

use App\Models\Consumer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('order/{source:token}/store', function (Source $source) {

    $user = Consumer::firstOrNew([
        'prenom' =>  request('prenom'),
        'nom'    =>  request('nom')
    ]);
    $user->adresse = request('adresse');
    $user->ville   = request('ville');
    $user->phone   = request('phone');
    $user->status  = "active";
    $user->save();

    $product_json = collect();
    $produit = Product::find(request('produit_id'));
    if (request('offre')) {
        $offre_id = request('offre');
        $offre = array_filter($produit->offres, function ($var) use ($offre_id) {
            return ($var['id'] == $offre_id);
        });
    }
    $offre = $offre[0];


    $product_json->push([
        "id"          => $produit->id,
        "active"      => request('offre') ? $offre['id'] : 0,
        "product"     => 0,
        "product_name"  => $produit->name,
        "unit_cost"   => $produit->sell,
        "quantity"    => request('offre') ? $offre['quantity'] : request('quantity'),
        "sub_total"   => request('offre') ? ($offre['quantity'] * $offre['unit_cost']) : (request('quantity') * $produit->sell)
    ]);

    $order              = new Order();
    $order->status      = 'NEW';
    $order->package     = 'UNPACKED';
    $order->source_id   = $source->id;
    $order->consumer_id = $user->id;
    $order->upsell_json = $product_json;
    $order->total       = request('offre') ? ($offre['quantity'] * $offre['unit_cost']) : (request('quantity') * $produit->sell);
    $order->save();

    $responce['message'] = 'ok';
    return response()->json($responce, 200);
});



Route::middleware('auth:api', 'cors')->get('/user', function (Request $request) {
    Log::debug('User:' . serialize($request->user()));
    return $request->user();
});



Route::namespace('App\Http\Controllers\API\User')->middleware('cors')->prefix('auth')->name('auth.')->group(function () {
    Route::post('login', 'AuthController@login');
});

Route::namespace('App\\Http\\Controllers\\API\V1')->middleware(['cors','auth:api'])->group(function () {
    Route::get('profile', 'ProfileController@profile');
    Route::get('dashboard', 'ProfileController@dashboard');
    Route::get('dashboard-products', 'ProfileController@getProduct');
    Route::get('dashboard-delivery', 'ProfileController@getDelivery');
    Route::get('dashboard-company', 'ProfileController@getCompany');
    Route::get('dashboard-city', 'ProfileController@getCity');
    Route::get('dashboard-agent', 'ProfileController@getAgent');

    Route::put('profile', 'ProfileController@updateProfile');
    Route::post('change-password', 'ProfileController@changePassword');
    Route::get('auth/verify', 'UserController@verify');
    Route::get('tag/list', 'TagController@list');
    Route::get('sources/list', 'SourceController@list');
    Route::get('shippings/list', 'ShippingController@list');
    Route::get('category/list', 'CategoryController@list');
    Route::post('product/upload', 'ProductController@upload');

    Route::get('consumers/list', 'ConsumerController@list');
    Route::get('products/list', 'ProductController@list');
    Route::get('permissions/list/{id}', 'PermissionController@indexByRole');

    Route::get('order-delivred/{shipping_id}', 'OrderController@getDelivryOrder');
    Route::post('order/import', 'OrderController@import');

    Route::apiResources([
        'user'      => 'UserController',
        'role'      => 'RoleController',
        'permission'      => 'permissionController',
        'product'   => 'ProductController',
        'consumer'  => 'ConsumerController',
        'category'  => 'CategoryController',
        'tag'       => 'TagController',
        'source'    => 'SourceController',
        'delivery'  => 'ShippingController',
        'company'   => 'ShippingCompanyController',
        'order'     => 'OrderController',
        'country'   => 'CityController',
    ]);
    // delivery
    Route::group(['prefix' => 'delivery'], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('login', 'Delivery\AuthController@login');
        });
        Route::group([
            'middleware' => 'auth:shipping-api'
        ], function () {
            Route::get('logout', 'Delivery\AuthController@logout');
            Route::get('user', 'Delivery\AuthController@user');
        });
    });
});


//namespace('App/Http/Controllers/API/Auth/Delivery')->

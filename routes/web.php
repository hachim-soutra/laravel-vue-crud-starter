<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    QrCode::size(500)
            ->format('png')
            ->generate('codingdriver.com', public_path('images/qrcode.png'));
    // return view('welcome');
    return redirect('/dashboard');
});
Route::get('/seed', function () {

    $permissions = [
        'admin',
        'client',
        'manager',
        'suivi',
        'confirmation',
        'rammassage',
     ];


     foreach ($permissions as $permission) {

        $role = Role::where([
            'name' => $permission
        ])->first();

        $role->givePermissionTo(Permission::all());
     }


});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('home', function () {
    return redirect('/dashboard');
})->where('any', '.*');

Route::get('/shippings/delivery/{any}', function () {
    return view('home');
})->where('any', '.*')
->middleware('auth');

Route::get('/{vue_capture?}', function () {
    return view('home');
})->where('vue_capture', '.*')
->middleware('auth');

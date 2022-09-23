<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
/*
|--------------------------------------------------------------------------
| API Routes
|-------------------------------------------------------------------------- 
*/
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Register and Login User 
Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'api',
    'prefix' => 'v1'
], function () {
    Route::post('/signup', 'UsersController@register');
    Route::post('/signin', 'UsersController@login');
});

// Vendor activities
Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'api',
    'prefix' => 'v1'
], function () {
    Route::post('/create-shop', 'VendorsController@create_shop');
    Route::post('/deactivate/{id}', 'VendorsController@deactivate_vendor');
    Route::post('/activate/{id}', 'VendorsController@activate_vendor');
    Route::get('/get_shops', 'VendorsController@get_shops');
    Route::get('/get_shop/{id}', 'VendorsController@view_shop');
    Route::get('/get_shop_by_admin', 'VendorsController@get_all_shops');
    Route::post('/make_user_admin/{id}', 'VendorsController@make_admin');
});



//Admin Activities On registered users 
Route::group([
    'namespace' => 'App\Http\Controllers',
], function () {
    Route::get('/all_users', 'UsersController@get_all_users');
    Route::get('/get_user/{id}', 'UsersController@get_user_by_id');
    Route::post('/logout', 'UsersController@logout');



});


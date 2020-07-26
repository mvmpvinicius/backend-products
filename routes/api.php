<?php

use Illuminate\Http\Request;
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

// Temporary setup for local testing //
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
///////////////////////////////////////

Route::post('user/login', 'LoginController@post');
Route::post('user/register', 'RegisterController@post');
Route::get('user/logout', 'LogoutController@get');

Route::middleware(['auth:api'])->group(function () {
    Route::get('product', 'ProductController@get');
    Route::post('product', 'ProductController@post');
    Route::put('product/{product}', 'ProductController@put');
});

<?php

use Illuminate\Http\Request;

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


// KRIVO! NE OVAKO RADITI!
// Route::post('/v2/authenticate.php', 'Api\V2\AuthController@login')->name('authenticate.php');

// API V2

Route::middleware('api')->get('/v2/testAuth', 'Api\V2\TestAuthController@test')->name('testAuth');
Route::middleware('api')->get('/v2/testLogin', 'Api\V2\TestLoginController@test')->name('testLogin');

// Route::middleware('api')->post('/v2/authenticate.php', 'Api\V2\AuthController@test')->name('authenticate.php');

Route::middleware('api')->post('/v2/authenticate.php', 'Api\V2\AuthController@authenticate_client')->name('authenticate.php');
Route::middleware('api')->post('/v2/login.php', 'Api\V2\LoginController@login_user')->name('login.php');


// API V3

Route::middleware('api')->get('/v3/testAuth', 'Api\V3\TestAuthController@test')->name('testAuth');
Route::middleware('api')->get('/v3/testLogin', 'Api\V3\TestLoginController@test')->name('testLogin');

Route::middleware('api')->post('/v3/authenticate.php', 'Api\V3\AuthController@authenticate_client')->name('authenticate.php');
Route::middleware('api')->post('/v3/login.php', 'Api\V3\LoginController@login_user')->name('login.php');

Route::middleware('api')->post('/v3/request-pwd-reset.php', 'Api\V3\PasswordResetController@request_pwd_reset')->name('request-pwd-reset.php');
Route::middleware('api')->post('/v3/auth-pwd-reset-request.php', 'Api\V3\PasswordResetController@auth_pwd_reset_request')->name('auth-pwd-reset-request.php');
Route::middleware('api')->post('/v3/reset-pwd.php', 'Api\V3\PasswordResetController@reset_pwd')->name('reset_pwd.php');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
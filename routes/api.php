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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'Api\Auth\AuthController@login');
    Route::post('signup', 'Api\Auth\AuthController@signUp');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'Api\Auth\AuthController@logout');
        Route::get('users/self', 'Api\User\UserController@self');
        Route::post('users', 'Api\User\UserController@store')->middleware('permission:employee.store');
        Route::get('users', 'Api\User\UserController@index')->middleware('permission:users.index');
        Route::get('users/{id}', 'Api\User\UserController@show')->middleware('permission:users.show');
    });
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

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
    /**Login */
    Route::post('login', 'Api\Auth\AuthController@login');
    Route::post('signup', 'Api\Auth\AuthController@signUp');
    /**Rooms */
    Route::get('rooms', 'Api\Room\RoomController@index');
    Route::get('rooms/{id}', 'Api\Room\RoomController@show');
    
    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'Api\Auth\AuthController@logout');
        
        /**User */
        Route::get('users/self', 'Api\User\UserController@self');
        Route::post('users', 'Api\User\UserController@store')->middleware('permission:employee.store');
        Route::get('users', 'Api\User\UserController@index')->middleware('permission:users.index');
        Route::get('users/{id}', 'Api\User\UserController@show')->middleware('permission:users.show');
        
        /**Rooms */
        Route::resource('rooms','Api\Room\RoomController',['only'=>['store','destroy']])->middleware('permission:rooms.store');
        Route::put('rooms/{id}', 'Api\Room\RoomController@update')->middleware('permission:rooms.update');
        
        /**Record */
        Route::resource('record','Api\Record\RecordController',['only'=>['index','show','update']])->middleware('permission:record.update');
        Route::resource('record','Api\Record\RecordController',['only'=>['store']]);
        /**Rooms Record */
        Route::resource('room.records','Api\Room\RoomRecordController',['only'=>['index','show']])->middleware('permission:rooms.update');
    });
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

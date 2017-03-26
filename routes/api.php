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

Route::resource('employee', 'EmployeeController',
    [
        'middleware' => 'App\Http\Middleware\RestAuth',
        'only' => ['show', 'store', 'update', 'destroy']
    ]);

Route::group(['prefix' => 'user'], function ()
{
    Route::post('login', 'AuthenticationController@login');
    Route::post('logout', 'AuthenticationController@logout');
});

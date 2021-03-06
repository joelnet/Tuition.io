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

Route::group(['middleware' => 'App\Http\Middleware\RestAuth'], function ()
{
    Route::get('employees', 'EmployeeController@all');

    Route::resource('employees', 'EmployeeController', ['only' =>
        ['show', 'store', 'update', 'destroy']
    ]);
});

Route::group(['prefix' => 'user'], function ()
{
    Route::post('login', 'AuthenticationController@login');
    Route::post('logout', 'AuthenticationController@logout');
    Route::post('check', 'AuthenticationController@check');
});

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

Route::post("/foo", "Api\FooController@say");

Route::group([
    'prefix' => '/v1',
    'middleware' => ['api']
], function () {
    Route::post('/user/login', 'Api\LoginController@login');
});

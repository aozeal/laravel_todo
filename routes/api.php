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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/test', function(Request $request){
    echo 'hello\n';
});

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/todo/{id}/done', 'App\Http\Controllers\Api\TodoController@doneFromApi');
    Route::get('/todo/{id}/delete', 'App\Http\Controllers\Api\TodoController@destroyFromApi');    
});


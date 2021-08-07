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

Route::put('/todo/{id}/done', 'App\Http\Controllers\Api\TodoController@done')->name('todo.done');
Route::delete('/todo/{id}', 'App\Http\Controllers\Api\TodoController@destroy')->name('todo.delete');

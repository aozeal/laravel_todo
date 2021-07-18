<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('todo_history', 'App\Http\Controllers\TodoHistoryController@index');
Route::get('todo_history/{id}', 'App\Http\Controllers\TodoHistoryController@show');

Route::resource('todo', 'App\Http\Controllers\TodoController');

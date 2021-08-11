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

Route::group(['middleware'=> ['auth']], function(){
    Route::get('todo_history', 'App\Http\Controllers\TodoHistoryController@index')->name('todo_history.index');
    Route::get('todo_history/{id}', 'App\Http\Controllers\TodoHistoryController@show')->name('todo_history.show');;
});


//Route::resource('todo', 'App\Http\Controllers\TodoController');
Route::group(['middleware' => ['auth']], function(){
    Route::get('/todo/create', 'App\Http\Controllers\TodoController@create')->name('todo.create');
    Route::get('/todo/{id}/edit', 'App\Http\Controllers\TodoController@edit')->name('todo.edit');
    Route::get('/todo/{id}', 'App\Http\Controllers\TodoController@show')->name('todo.show');
    Route::get('/todo', 'App\Http\Controllers\TodoController@index')->name('todo.index');
    Route::post('/todo', 'App\Http\Controllers\TodoController@store')->name('todo.store');
    Route::put('/todo/{id}/done', 'App\Http\Controllers\TodoController@done')->name('todo.done');
    Route::put('/todo/{id}', 'App\Http\Controllers\TodoController@update')->name('todo.update');
    Route::delete('/todo/{id}', 'App\Http\Controllers\TodoController@destroy')->name('todo.delete');

    Route::get('/user/{id}/edit', 'App\Http\Controllers\UserController@edit')->name('user.edit');
    Route::get('/user/{id}', 'App\Http\Controllers\UserController@show')->name('user.show');
    Route::put('/user/{id}', 'App\Http\Controllers\UserController@update')->name('user.update');
});

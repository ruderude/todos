<?php

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
    return redirect()->route('todo.index');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function(){

    Route::get('todo/all', 'TodosController@all')->name('todo.all');
    Route::resource('todo', 'TodosController', ['only' => ['index', 'store', 'update', 'show', 'destroy']]);


});

Route::group(['middleware' => 'auth'], function(){

    Route::resource('user', 'UsersController', ['only' => ['index', 'store', 'update', 'show', 'destroy']]);

});

Auth::routes();

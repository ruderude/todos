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
    return redirect()->route('todo.top');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'todo', 'middleware' => 'auth'], function(){

    Route::get('', 'TodosController@index')->name('todo.top');

    Route::post('store', 'TodosController@store')->name('todo.store');
    Route::post('update/{id}', 'TodosController@update')->name('todo.update');
    Route::get('delete/{id}', 'TodosController@delete')->name('todo.delete');
    Route::get('all', 'TodosController@all')->name('todo.all');

});

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function(){

    Route::get('', 'UsersController@index')->name('user.top');
    
    Route::post('update', 'UsersController@update')->name('user.update');

});

Auth::routes();

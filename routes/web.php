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

//Route::get('/', function () {return view('welcome');});


Route::get('/', 'TaskController@index')->name('tasks');
Route::post('store', 'TaskController@store');
Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/edit/{id}', 'HomeController@edit')->name('edit');
Route::post('update/{id}', 'HomeController@update');
Route::delete('delete/{id}', 'HomeController@delete');

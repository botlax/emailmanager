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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/add', 'EmailController@create');
Route::post('/add', 'EmailController@store')->name('email-add');
Route::get('/delete', 'EmailController@edit');
Route::post('/delete/{id}', 'EmailController@destroy')->name('email-delete')->where('id', '^[0-9]*$');
Route::post('/deleteforward/{id}', 'EmailController@forwardDestroy')->name('forward-delete')->where('id', '^[0-9]*$');
Route::post('/update/{id}', 'EmailController@update')->name('email-update')->where('id', '^[0-9]*$');
Route::post('/forward/{id}', 'EmailController@forwardUpdate')->name('forward-update')->where('id', '^[0-9]*$');
Route::post('/respond/{id}', 'EmailController@respondUpdate')->name('respond-update')->where('id', '^[0-9]*$');
Route::post('/deleterespond/{id}', 'EmailController@respondDestroy')->name('respond-delete')->where('id', '^[0-9]*$');
Route::get('/email/{id}', 'EmailController@show')->where('id', '^[0-9]*$');

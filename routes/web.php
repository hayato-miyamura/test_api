<?php

use App\Http\Controllers\ItemController;
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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('login/google', 'Auth\LoginController@redirectToGoogle');
Route::get('login/google/callback', 'Auth\LoginController@googleCallback');

Route::get('/', 'ItemController@index')->name('item.index');
Route::get('/item', 'ItemController@show')->name('item.show');
Route::post('/item', 'ItemController@store')->name('item.store');
Route::put('/item/{id}', 'ItemController@update')->name('item.update');
Route::delete('/item/{id}', 'ItemController@destroy')->name('item.destroy');
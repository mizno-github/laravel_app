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

Route::resource('/todo','TodoController');
// +--------+-----------+------------------+--------------+---------------------------------------------+--------------+
// | Domain | Method    | URI              | Name         | Action                                      | Middleware   |
// +--------+-----------+------------------+--------------+---------------------------------------------+--------------+
// |        | GET|HEAD  | api/user         |              | Closure                                     | api,auth:api |
// |        | GET|HEAD  | todo             | todo.index   | App\Http\Controllers\TodoController@index   | web          |
// |        | POST      | todo             | todo.store   | App\Http\Controllers\TodoController@store   | web          |
// |        | GET|HEAD  | todo/create      | todo.create  | App\Http\Controllers\TodoController@create  | web          |
// |        | GET|HEAD  | todo/{todo}      | todo.show    | App\Http\Controllers\TodoController@show    | web          |
// |        | PUT|PATCH | todo/{todo}      | todo.update  | App\Http\Controllers\TodoController@update  | web          |
// |        | DELETE    | todo/{todo}      | todo.destroy | App\Http\Controllers\TodoController@destroy | web          |
// |        | GET|HEAD  | todo/{todo}/edit | todo.edit    | App\Http\Controllers\TodoController@edit    | web          |
// +--------+-----------+------------------+--------------+---------------------------------------------+--------------+
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
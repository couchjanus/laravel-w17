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


Route::group(['prefix' => 'blog'], function () {
    Route::get('', 'BlogController@index')->name('blog');
    Route::get('/{id}', 'BlogController@show')->name('show');
    Route::get('/create', 'BlogController@create')->name('create');
    Route::post('/create', 'BlogController@store')->name('store');
    Route::get('/{id}/edit', 'BlogController@edit')->name('edit');
    Route::put('/{id}/edit', 'BlogController@update')->name('update');
});

Route::namespace('Admin')
    ->prefix('admin')
    ->as('admin.')
	->group(function () {
        Route::get('', 'DashboardController')->name('index'); 
        Route::get('categories/trashed', 'CategoryController@trashed')->name('categories.trashed');
        Route::post('categories/restore/{id}', 'CategoryController@restore')->name('categories.restore');
        Route::delete('categories/force/{id}', 'CategoryController@force')->name('categories.force');
        Route::resource('categories', 'CategoryController');
    	Route::resource('users', 'UserController');
});

// Еще какие-то маршруты....
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::fallback(function() {
    return "Oops… How you've trapped here?";
});

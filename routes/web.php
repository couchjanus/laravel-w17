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
    Route::get('/{id}', 'BlogController@show')->name('blog.show');
    Route::get('/create', 'BlogController@create')->name('create');
    Route::post('/create', 'BlogController@store')->name('store');
    Route::get('/{id}/edit', 'BlogController@edit')->name('edit');
    Route::put('/{id}/edit', 'BlogController@update')->name('update');
});

Route::get('search', 'SearchController@index')->name('search.index');
Route::get('search-results', 'SearchController@search')->name('search.result');

// category.show

Route::get('/category/{id}', 'CategoryController@show')->name('category.show');

// Route::middleware('auth', 'admin')->namespace('Admin')
Route::namespace('Admin')
    ->prefix('admin')
    ->as('admin.')
	->group(function () {
        Route::get('', 'DashboardController')->name('index'); 
        Route::get('categories/trashed', 'CategoryController@trashed')->name('categories.trashed');
        Route::post('categories/restore/{id}', 'CategoryController@restore')->name('categories.restore');
        Route::delete('categories/force/{id}', 'CategoryController@force')->name('categories.force');
        Route::resource('categories', 'CategoryController');
  
        Route::get('users/trashed', 'UserController@trashed')->name('users.trashed');
        Route::post('users/restore/{id}', 'UserController@restore')->name('users.restore');
        Route::delete('users/force/{id}', 'UserController@force')->name('users.force');
  
        Route::resource('users', 'UserController');
        Route::resource('tags', 'TagController');
        Route::resource('posts', 'PostController');

        Route::get('admins/trashed', 'AdminController@trashed')->name('admins.trashed');
        Route::post('admins/restore/{id}', 'AdminController@restore')->name('admins.restore');
        Route::delete('admins/force/{id}', 'AdminController@force')->name('admins.force');
        Route::resource('admins', 'AdminController');
        
        Route::get('invitations', 'InvitationsController@index')->name('showInvitations');
        Route::post('invite/{id}', 'InvitationsController@sendInvite')
        ->name('send.invite');

        Route::resource('permissions', 'PermissionController');
        Route::resource('roles', 'RoleController');
        
         /**
         * Admin Auth Route(s)
         */
        Route::namespace('Auth')->group(function(){
            //Login Routes
            Route::get('/login','LoginController@showLoginForm')->name('login');
            Route::post('/login','LoginController@login');
            Route::post('/logout','LoginController@logout')->name('logout');

            //Forgot Password Routes
            Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
            Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');

            //Reset Password Routes
            Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
            Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');

        });
});

// Еще какие-то маршруты....
Auth::routes();
// Auth::routes(['verify' => true]);

Route::get('/home', function () {
    return redirect('profile');
});

Route::middleware('auth')
    ->prefix('profile')
    ->as('profile.')
	->group(function () {
        Route::get('', 'ProfileController@index')
            ->name('home');
        Route::get('info', 'ProfileController@info')
            ->name('info');
        Route::put('store', 'ProfileController@store')
            ->name('store');
});

// Socialite Register Routes

Route::get('social/{provider}', 'Auth\SocialController@redirect')->name('social.redirect');
Route::get('social/{provider}/callback', 'Auth\SocialController@callback')->name('social.callback');

Route::get('register/request', 'Auth\RegisterController@requestInvitation')->name('requestInvitation');
Route::post('invitations', 'InvitationController@store')->middleware('guest')->name('storeInvitation');

Route::fallback(function() {
    return "Oops… How you've trapped here?";
});

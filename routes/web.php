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

        Route::get('invitations', 'InvitationsController@index')->name('showInvitations');
        Route::post('invite/{id}', 'InvitationsController@sendInvite')
        ->name('send.invite');
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

// 


Route::get('reminder', function () {
    return new \App\Mail\Reminder();
})->name('reminder');

// Route::get('reminder', function () {
//     return new App\Mail\Reminder('Blaha Muha Coming Soon');
// });

// Route::post('reminder', function (\Illuminate\Http\Request $request) {
//     dd($request);
// })->name('reminder');

// Route::post('reminder', function (
//     \Illuminate\Http\Request $request, 
//     \Illuminate\Mail\Mailer $mailer) {
//     $mailer->to($request->email)
//     ->send(new \App\Mail\Reminder($request->event));
//            return redirect()->back();    
// })->name('reminder');

// Route::get('invite', function () {
//     return (new App\Mail\InvitationMail())->render();
// });
 
// Route::get('invite', function () {
//     $url = 'Your Invite Link';
//     return (new App\Mail\InvitationMail($url))->render();
//  });
 

Route::get('register/request', 'Auth\RegisterController@requestInvitation')->name('requestInvitation');
Route::post('invitations', 'InvitationController@store')->middleware('guest')->name('storeInvitation');
     

Route::fallback(function() {
    return "Oops… How you've trapped here?";
});

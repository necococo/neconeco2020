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
//トップ
Route::get('/', 'MicropostsController@index')->name('microposts.index');;
Route::get('/usage', function () {
    return view('usage');
});

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
// ログイン認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

Route::group(['middleware' => 'auth'], function () {
   Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);
    // create,storeはRegisterControllerがやってくれている
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
        
        Route::post('favorite', 'FavoritesController@store')->name('user.favorite');
        Route::delete('unfavorite', 'FavoritesController@destroy')->name('user.unfavorite');
        Route::get('favoritings', 'UsersController@favoritings')->name('users.favoritings');
    });
    Route::get('microposts/search', 'MicropostsController@search');
    Route::get('microposts/all_map', 'MicropostsController@all_map')->name('microposts.all_map');
    Route::resource('microposts', 'MicropostsController', ['only' => ['create', 'store', 'show', 'edit', 'update', 'destroy']]);
   
    Route::group(['prefix' => 'microposts/{id}'], function () {
        Route::resource('comment', 'CommentsController', ['only' => ['store']]);
 
    });
});



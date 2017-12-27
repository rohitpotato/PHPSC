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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/alert', function(){
	return redirect()->route('home')->with('info', 'You have signed up!');
});

Route::get('/signup', 'AuthController@getSignup')->name('auth.signup');
Route::post('/signup', 'AuthController@postSignup'); 

Route::get('/signin', 'AuthController@getSignin')->name('auth.signin');

Route::post('/signin', 'AuthController@postSignin');

Route::get('/signout', 'AuthController@signOut')->name('auth.signout');

Route::get('/search' , 'SearchController@getResults')->name('search.results');

Route::get('/user/{username}', 'ProfileController@getProfile')->name('profile.index');

Route::get('/profile/edit', 'ProfileController@getEdit')->name('profile.edit');

Route::post('/profile/edit', 'ProfileController@postEdit');

Route::get('/friends/', ['uses' => 'FriendController@getIndex', 'as' => 'friend.index','middleware'=>['auth'], ]);

Route::get('/friends/add/{username}', ['uses' => 'FriendController@getAdd', 'as' => 'friend.add','middleware'=>['auth'], ]);


Route::get('/friends/accept/{username}', ['uses' => 'FriendController@getAccept', 'as' => 'friend.accept','middleware'=>['auth'], ]);

Route::post('/status', ['uses' => 'StatusController@postStatus', 'as' => 'status.post','middleware'=>['auth'], ]);

Route::get('post/edit/{id}', ['uses' => 'StatusController@editStatus', 'as' => 'status.edit','middleware'=>['auth'], ]);

Route::post('/posts/update/{id}', ['uses' => 'StatusController@updateStatus', 'as' => 'status.update','middleware'=>['auth'], ] );

Route::post('/status/{statusId}/reply', ['uses' => 'StatusController@postReply', 'as' => 'status.reply','middleware'=>['auth'], ]);

Route::get('/status/{statusId}/like', ['uses' => 'StatusController@getLike', 'as' => 'status.like','middleware'=>['auth'], ] );

Route::get('/status/{replyId}/edit' , ['uses' => 'StatusController@editComment', 'as' => 'status.commentedit','middleware'=>['auth'], ] );

Route::post('/status/{replyId}/update', ['uses' => 'StatusController@updateComment', 'as' => 'status.commentupdate','middleware'=>['auth'], ]);

Route::post('/posts/delete/{id}', ['uses' => 'StatusController@deleteStatus', 'as' => 'status.delete','middleware'=>['auth'], ]);
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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/threads', 'ThreadsController@index');

Route::get('/threads/create', 'ThreadsController@create');

Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');

Route::post('/locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('/locked-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');

Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy');

Route::post('/threads', 'ThreadsController@store')->middleware('must-be-confirmed');

Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');

Route::get('threads/{channel}', 'ThreadsController@index');

Route::post('/replies/{reply}/favorites', 'FavouritesController@store');

Route::delete('/replies/{reply}/favorites', 'FavouritesController@destroy');

Route::post('/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');

Route::get('profiles/{user}', 'ProfilesController@show');
Route::delete('profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');
Route::get('profiles/{user}/notifications', 'UserNotificationsController@index');


Route::delete('/replies/{reply}', 'RepliesController@destroy');

Route::patch('/replies/{reply}', 'RepliesController@update');


Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptions@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptions@destroy')->middleware('auth');

Route::get('api/users', 'Api\UsersController@index');
Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('avatar');

Route::get('register/confirm', 'Auth\RegisterConfirmationController@index');
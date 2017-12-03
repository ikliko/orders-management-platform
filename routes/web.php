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
Route::get('/', 'HomeController@guest');
Route::group(['prefix' => 'login'], function () {
	if (env('DEMO')) {
		Route::get('regular', 'Auth\LoginController@regular');
		if (env('DEMO_ADMIN')) {
			Route::get('admin', 'Auth\LoginController@admin');
		}
	}
});
Auth::routes();
Route::group(['middleware' => ['auth']], function () {
	Route::group(['prefix' => 'orders'], function () {
		Route::get('all', 'OrdersController@all');
		Route::get('trashed', 'OrdersController@trashed');
		Route::post('{id}/restore', 'OrdersController@restore');
	});
	Route::resource('orders', 'OrdersController');
	
	Route::group(['prefix' => 'settings'], function () {
		Route::get('/', 'UsersController@settings');
		Route::post('/', 'UsersController@updateProfile');
		Route::get('security', 'UsersController@security');
		Route::post('security', 'UsersController@securityUpdate');
	});
	
	Route::group(['prefix' => 'products'], function() {
		Route::get('trashed', 'ProductsController@trashed');
		Route::post('{id}/restore', 'ProductsController@restore');
	});
	Route::resource('products', 'ProductsController');
	
	Route::group(['prefix' => 'users'], function() {
		Route::get('trashed', 'UsersController@trashed');
		Route::post('{id}/restore', 'UsersController@restore');
	});
	Route::resource('users', 'UsersController');
});
Route::get('/home', 'HomeController@auth')->name('home');

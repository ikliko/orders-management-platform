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
	Route::resource('/orders', 'OrdersController');
});
Route::get('/home', 'HomeController@auth')->name('home');

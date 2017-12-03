<?php

namespace App\Providers;

use App\Models\Product;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use \App\Models\Order;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		Schema::defaultStringLength(191);
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		view()->composer('menus.sidebar', function($view) {
			if(Auth::user()->is_admin) {
				$view->with('allOrders', Order::count());
				$view->with('trashedOrders', Order::onlyTrashed()->count());
				$view->with('allProducts', Product::count());
				$view->with('trashedProducts', Product::onlyTrashed()->count());
				$view->with('allUsers', User::count());
				$view->with('trashedUsers', User::onlyTrashed()->count());
			}
			$view->with('myOrders', Auth::user()->orders->count());
		});

		view()->composer('partials.components.filter', function($view) {
			$view->with('periods', [
				'all_time' => 'All time',
				'last_week' => 'Last 7 days',
				'today' => 'Today',
			]);
		});
	}
}

<?php

namespace App\Http\Controllers;

use App\Exceptions\NotAuthorized;
use App\Models\Order;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller {
	protected function validationRules() {
		$rules = [
			'product_id' => 'required',
			'quantity' => 'required',
		];

		if (Auth::check() && Auth::user()->is_admin) {
			$rules['user_id'] = 'required';
		}

		return $rules;
	}

	/**
	 * Displaying full listing of the resource
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function all(Request $request) {
		$usersOrders =
			User::where('name', 'like', '%' . $request->get('user_product') . '%')
				->with(['orders' => function ($orderQuery) use ($request) {
					$orderQuery->with('user')
						->with('details')
						->filter($request->all(['period']));
				}])
				->select()
				->get();

		$productsOrders =
			Product::where('name', 'like', '%' . $request->get('user_product') . '%')
				->with(['orders' => function ($orderQuery) use ($request) {
					$orderQuery->with('user')
						->with('details')
						->filter($request->all(['period']));
				}])
				->select()
				->get();

		$orders = collect([]);

		foreach ($usersOrders as $user) {
			foreach ($user->orders as $order) {
				$orders->push($order);
			}
		}

		foreach ($productsOrders as $product) {
			foreach ($product->orders as $order) {
				$orders->push($order);
			}
		}

		$orders = $orders->unique('id')->sortBy('created_at', SORT_DESC, true);

		$page = $request->get('page', 1); // Get the ?page=1 from the url
		$perPage = 5; // Number of items per page
		$offset = ($page * $perPage) - $perPage;

		$orders = new LengthAwarePaginator(
			array_slice($orders->toArray(), $offset, $perPage, true), // Only grab the items we need
			count($orders), // Total items
			$perPage, // Items per page
			$page, // Current page
			['path' => $request->url(), 'query' => $request->query()] // We need this so we can keep all old query parameters from the url
		);

		return view('orders.list', compact('orders'));
	}

	/**
	 * Displaying deleted listing of the resource
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function trashed() {
		$orders = Order::onlyTrashed()->paginate(5);

		return view('orders.list', compact('orders'));
	}

	/**
	 * Restores deleted resource
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function restore($orderId) {
		$order = Order::onlyTrashed()->find($orderId);
		$order->restore();

		return back();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$orders = Auth::user()->orders()->paginate(5);

		return view('orders.list', compact('orders'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('orders.modify');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$this->validate($request, $this->validationRules());

		$user = Auth::check() && Auth::user()->is_admin ? User::find($request->get('user_id')) : Auth::user();
		$product = Product::find($request->get('product_id'));
		$total = $product->price * $request->get('quantity');

		if ($product->discount && $request->get('quantity') > 2) {
			$total -= ($total * 0.2);
		}

		$user->orders()->create([
			'total' => $total
		])->details()->attach($product->id, [
			'quantity' => $request->get('quantity')
		]);

		return back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Order $order
	 * @return \Illuminate\Http\Response
	 */
	public function show(Order $order) {
		return view('orders.show', compact('order'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Order $order
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Order $order) {
		if (!Auth::user()->is_admin) {
			throw new NotAuthorized('Access denied', 401);
		}

		return view('orders.modify', compact('order'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Models\Order $order
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Order $order) {
		if (Auth::user()->is_admin) {
			$this->validate($request, $this->validationRules());
			$user = User::find($request->get('user_id'));
			$order->user_id = $user->id;
			$oldProduct = $order->details()->first();
			$order->details()->detach($oldProduct->id);
			$newProduct = Product::find($request->get('product_id'));
			$order->details()->attach($newProduct->id, [
				'quantity' => $request->get('quantity')
			]);
			$total = +$request->get('quantity') * $newProduct->price;
			if ($newProduct->discount && $request->get('quantity') > 2) {
				$total -= ($total * 0.2);
			}
			$order->total = $total;
			$order->save();

			return back();
		}

		throw new NotAuthorized('Access denied', 401);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Order $order
	 * @return \Illuminate\Http\Response
	 * @throws NotAuthorized
	 */
	public function destroy(Request $request, Order $order) {
		if (Auth::user()->is_admin) {
			$order->delete();

			if ($request->get('redirectTo')) {
				return redirect($request->get('redirectTo'));
			}

			return back();
		}

		throw new NotAuthorized('Access denied', 401);
	}
}

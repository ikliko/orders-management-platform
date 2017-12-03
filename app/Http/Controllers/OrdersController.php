<?php

namespace App\Http\Controllers;

use App\Exceptions\NotAuthorized;
use App\Models\Order;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;
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
				->with(['orders' => function ($t) use ($request) {
					$t->with('user')
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

		return view('orders.list', compact('orders'));
	}

	/**
	 * Displaying deleted listing of the resource
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function trashed() {
		$orders = Order::onlyTrashed()->get();

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
		$orders = Auth::user()->orders;

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
		if(Auth::user()->is_admin) {
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

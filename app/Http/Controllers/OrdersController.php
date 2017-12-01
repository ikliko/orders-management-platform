<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;

class OrdersController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$orders = Order::all();

		return view('welcome', compact('orders'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$this->validate($request, [
			'user_id' => 'required',
			'product_id' => 'required',
			'quantity' => 'required',
		]);

		$user = User::find($request->get('user_id'));
		$product = Product::find($request->get('product_id'));
		$total = $product->price * $request->get('quantity');
		if ($product->discount) {
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
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Order $order
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Order $order) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Models\Order $order
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Order $order) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Order $order
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Order $order) {
		$order->details()->detach();
		$order->delete();

		return back();
	}
}

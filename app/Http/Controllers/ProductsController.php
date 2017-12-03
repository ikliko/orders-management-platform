<?php

namespace App\Http\Controllers;

use App\Exceptions\NotAuthorized;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller {
	public function validationRules() {
		return [
			'name' => 'required',
			'price' => 'required|numeric',
		];
	}

	public function accessible() {
		if (!Auth::user()->is_admin) {
			throw new NotAuthorized('Access denied', 401);
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 * @throws NotAuthorized
	 */
	public function index() {
		$this->accessible();
		$products = Product::paginate(5);

		return view('products.list', compact('products'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 * @throws NotAuthorized
	 */
	public function create() {
		$this->accessible();

		return view('products.modify');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 * @throws NotAuthorized
	 */
	public function store(Request $request) {
		$this->accessible();
		$this->validate($request, $this->validationRules());
		Product::create([
			'name' => $request->get('name'),
			'price' => $request->get('price'),
			'discount' => !!$request->get('discount'),
		]);

		return back();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Product $product
	 * @return \Illuminate\Http\Response
	 * @throws NotAuthorized
	 */
	public function edit(Product $product) {
		$this->accessible();

		return view('products.modify', compact('product'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Models\Product $product
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Product $product) {
		$this->accessible();
		$this->validate($request, $this->validationRules());
		$product->name = $request->get('name');
		$product->price = $request->get('price');
		$product->discount = !!$request->get('discount');
		$product->save();

		return back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Product $product
	 * @return \Illuminate\Http\Response
	 * @throws NotAuthorized
	 */
	public function destroy(Request $request, Product $product) {
		$this->accessible();
		$product->delete();

		if ($request->get('redirectTo')) {
			return redirect($request->get('redirectTo'));
		}

		return back();
	}

	public function trashed() {
		$this->accessible();
		$products = Product::onlyTrashed()->paginate(5);

		return view('products.list',compact('products'));
	}

	public function restore($id) {
		$this->accessible();
		$product = Product::onlyTrashed()->find($id);
		$product->restore();

		return back();
	}
}

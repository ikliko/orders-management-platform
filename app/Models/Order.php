<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
	protected $fillable = [
		'total',
	];

	public function user() {
		return $this->belongsTo(User::class);
	}

	public function details() {
		return $this->belongsToMany(Product::class)->withPivot(['quantity']);
	}

	public static function rules() {
		$rules = [
			'total' => 'required'
		];

		return $rules;
	}

	public static function createNew($data) {
		$product = Product::find($data['product_id']);
		$total = $data['quantity']*$product->price;
		if($product->discount) {
			$total -= ($total*0.2);
		}

		$order = new Order();
		$order->user_id = $data['user_id'];
		$order->total = $total;
		$order->save();

		$orderDetails = new OrderProduct();
		$orderDetails->product_id = $product->id;
		$orderDetails->quantity = $data['quantity'];
		$order->details->save($orderDetails);
		return $order;
	}
}

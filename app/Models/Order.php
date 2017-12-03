<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Order extends Model {
	use SoftDeletes;

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at', 'created_at'];
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
		$total = $data['quantity'] * $product->price;
		if ($product->discount) {
			$total -= ($total * 0.2);
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

	public function scopeFilter($query, $filters) {
		if ($period = $filters['period']) {
			$today = Carbon::now();
			switch ($period) {
				case 'last_week':
					$startDate = Carbon::today()->subDay(7);
					$startDate->hour = 0;
					$startDate->minute = 0;
					$startDate->second = 0;
					$query->where('created_at', '>=', $startDate)
						->where('created_at', '<=', $today);
					break;
				case 'today':
					$startDate = Carbon::today();
					$query->where('created_at', '>=', $startDate)
						->where('created_at', '<=', $today);
					break;
			}
		}
	}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {
	use SoftDeletes;

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];
	protected $fillable = [
		'name',
		'price',
		'discount'
	];

	public function orders() {
		return $this->belongsToMany(Order::class)->withPivot(['quantity']);
	}
}

<?php

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Product::truncate();

		factory(Product::class, 5)->create();

		Product::create([
			'name' => 'Coca Cola',
			'price' => 1.60,
			'discount' => false
		]);

		Product::create([
			'name' => 'Pepsi Cola',
			'price' => 1.80,
			'discount' => true
		]);
	}
}

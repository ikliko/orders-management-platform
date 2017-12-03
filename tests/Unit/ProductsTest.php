<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase {
	use DatabaseMigrations, RefreshDatabase;

	protected static $product = [
		'name' => 'Pepsi Cola',
		'price' => 1.23,
	];

	protected static $productDiscount = [
		'name' => 'Pepsi Cola',
		'price' => 1.23,
		'discount' => true
	];

	public static function createProduct($discount = false) {
		if ($discount) {
			$product = self::$productDiscount;
		} else {
			$product = self::$product;
		}

		Product::create($product);
	}

	/**
	 * Storing product.
	 *
	 * @return void
	 */
	public function testStoreProduct() {
		self::createProduct();
		$product = Product::first();

		$this->assertTrue(
			$product->name === self::$product['name']
			&& +$product->price === self::$product['price']
		);
	}

	/**
	 * Update product test.
	 *
	 * @return  void
	 */
	public function testUpdateProduct() {
		$newProductData = [
			'name' => 'Coca cola',
			'price' => 1.89
		];
		$this->createProduct();
		$product = Product::first();
		$product->update($newProductData);
		$productUpdated = Product::first();

		$this->assertTrue(
			$productUpdated->name === $newProductData['name']
			&& +$productUpdated->price === $newProductData['price']
		);
	}

	/**
	 * Deleting product test.
	 *
	 * @return void
	 */
	public function testDeleteProduct() {
		$this->createProduct();
		$product = Product::first();
		$product->delete();
		$products = Product::all();

		$this->assertTrue(count($products) === 0);
	}
}

<?php

namespace Tests\Unit;

use App\Http\Controllers\OrdersController;
use App\Models\Order;
use App\Models\Product;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrdersTest extends TestCase {
	use DatabaseMigrations, RefreshDatabase;

	protected $user;
	protected $product;
	protected $quantity = 3;
	protected $total;

	public function createOrder($discount = false) {
		UsersTest::createUser();
		ProductsTest::createProduct($discount);
		$this->user = User::first();
		$this->product = Product::first();
		$request = new Request([
			'product_id' => $this->product->id,
			'quantity' => $this->quantity,
		]);
		Auth::login($this->user);
		$ordersController = new OrdersController();
		$ordersController->store($request);
	}

	/**
	 * Create order test
	 *
	 * @return void
	 */
	public function testCreateOrder() {
		$this->createOrder();
		$order = Order::first();

		$total = +$this->product->price * $this->quantity;
		$this->assertTrue(
			$order->user->id === $this->user->id
			&& $order->details->first()->id === $this->product->id
			&& $order->details->first()->price === $this->product->price
			&& $order->details->first()->pivot->quantity === $this->quantity
			&& +$order->total === $total
		);
	}

	/**
	 * Create order from user test
	 *
	 * @return void
	 */
	public function testCreateOrderWithDiscount() {
		$this->createOrder(true);
		$order = Order::first();

		$total = +$this->product->price * $this->quantity;
		$total -= ($total * 0.2);
		$total = round($total, 2);
		$this->assertTrue(
			$order->user->id === $this->user->id
			&& $order->details->first()->id === $this->product->id
			&& $order->details->first()->price === $this->product->price
			&& $order->details->first()->pivot->quantity === $this->quantity
			&& +$order->total === $total
		);
	}
}

<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase {
	use DatabaseMigrations, RefreshDatabase;

	protected static $user = [
		'name' => 'User Test',
		'email' => 'user@example.com',
		'password' => '1234',
	];

	public static function createUser() {
		User::create([
			'name' => self::$user['name'],
			'email' => self::$user['email'],
			'password' => bcrypt(self::$user['password']),
		]);
	}

	/**
	 * Storing user in db test.
	 *
	 * @return void
	 */
	public function testStoreUserInDb() {
		self::createUser();
		$user = User::first();

		$this->assertTrue(
			$user->name === self::$user['name']
			&& $user->email === self::$user['email']
		);
	}

	/**
	 * Testing delete user
	 *
	 * @return void
	 */
	public function testDeleteUserFromDb() {
		self::createUser();
		$user = User::first();
		$user->delete();
		$users = User::all();

		$this->assertTrue(count($users) === 0);
	}

	/**
	 * Testing update user
	 *
	 * @return void
	 */
	public function testUpdateUserFromDb() {
		$newName = 'User Changed';
		self::createUser();
		$user = User::first();
		$user->name = $newName;
		$user->save();
		$updatedUser = User::first();

		$this->assertTrue($updatedUser->name === $newName);
	}

	/**
	 * Testing login user
	 *
	 * @return void
	 */
	public function testLogin() {
		self::createUser();

		if(Auth::attempt(['email'=> self::$user['email'], 'password' => self::$user['password']])) {
			$this->assertTrue(true);
		} else {
			$this->assertTrue(false);
		}
	}
}


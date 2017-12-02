<?php

use Illuminate\Database\Seeder;
use \App\User;

class UsersTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
        User::truncate();

		factory(App\User::class, 20)->create();
		User::create([
			'name' => 'Admin Admin',
			'email' => 'admin@change.me',
			'password' => bcrypt('@dCa$h'),
			'is_admin' => true
		]);
	}
}

<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
		'name' => $faker->name(),
		'price' => $faker->randomFloat(2,1),
		'discount' => $faker->boolean(40)
    ];
});

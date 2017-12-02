<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
		'name' => $faker->randomElement(['Fanta', 'Sprite', 'Schweppes', 'Monster']),
		'price' => $faker->randomFloat(2,2,9),
		'discount' => $faker->boolean(0)
    ];
});

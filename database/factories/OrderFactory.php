<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Order::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1),
    ];
});

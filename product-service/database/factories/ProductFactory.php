<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Product::class, function (Faker $faker) {
    return [
        'id' => strtoupper(str_random(10)),
        'name' => $faker->name,
        'image' => str_random(10).'.png',
        'size' => $faker->randomElement([28,32]),
    ];
});

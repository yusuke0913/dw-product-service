<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Collection::class, function (Faker $faker) {
    return [
        'id' => $faker->name
    ];
});

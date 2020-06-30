<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Link;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Link::class, function (Faker $faker) {
    $customOrRandom = random_int(0, 1);
    $dateOrNull = random_int(0, 1);

    return [
        'hash' => $customOrRandom
            ? $faker->userName . $faker->numberBetween(1, 100)
            : Str::random(8),
        'link' => 'https://source.unsplash.com/collection/' . random_int(1, 50),
        'expired_at' => $dateOrNull ? $faker->date() : null
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\School\School::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'nickname' => $faker->companySuffix,
        'location' => $faker->city.', '.$faker->stateAbbr,
        'website' => $faker->url,
    ];
});

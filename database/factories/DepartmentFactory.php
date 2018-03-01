<?php

use Faker\Generator as Faker;

$factory->define(App\School\Department::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});

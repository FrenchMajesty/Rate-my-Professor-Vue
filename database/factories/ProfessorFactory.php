<?php

use Faker\Generator as Faker;

$factory->define(App\Professor\Professor::class, function (Faker $faker) {
    return [
    	'firstname' => $faker->firstname,
    	'lastname' => $faker->lastname,
    	'directory_url' => $faker->url,
    	'school_id' => factory(App\School\School::class)->create()->id,
    	'department_id' => factory(App\School\Department::class)->create()->id,
    ];
});

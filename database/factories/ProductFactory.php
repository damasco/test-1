<?php

use Faker\Generator as Faker;
use Faker\Provider\Lorem;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Product::class, function (Faker $faker) {
    $faker->addProvider(new Lorem($faker));
    
    return [
        'name' => $faker->word,
        'price' => $faker->numberBetween(100, 1000),
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Recipe;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Recipe::class, function (Faker $faker) {
	$faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($faker));
    return [
        'name' => $faker->foodName(),
        'cuisine' => 'cuisine',
        'type' => 'type',
        'ingredients' => 'Test Ingredients',
    ];
});

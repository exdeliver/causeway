<?php

/** @var Factory $factory */
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

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

$factory->define(Exdeliver\Causeway\Domain\Entities\Forum\Category::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'slug' => $faker->name,
        'description' => $faker->paragraph,
    ];
});

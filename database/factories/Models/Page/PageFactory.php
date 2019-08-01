<?php

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/* @var Factory $factory */

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

$factory->define(Exdeliver\Causeway\Domain\Entities\Page\Page::class, function (Faker $faker) {
    return [
        'user_id' => factory(Exdeliver\Causeway\Domain\Entities\User\User::class)->create()->id,
        'name' => $faker->name,
        'slug' => $faker->name,
        'content' => $faker->paragraph(10),
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use Faker\Generator as Faker;

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

$factory->define(Exdeliver\Causeway\Domain\Entities\PhotoAlbum\PhotoAlbum::class, function (Faker $faker) {
    return [
        'uuid' => $faker->uuid,
        'name' => $faker->name,
        'description' => $faker->paragraph,
        'file_name' => $faker->name,
        'file' => $faker->file(storage_path('app/public/uploads/test/test-rotterdam.png')),
    ];
});

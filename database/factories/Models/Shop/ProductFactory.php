<?php

/** @var Factory $factory */
use Exdeliver\Causeway\Domain\Entities\Shop\Product;
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

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'slug' => $faker->name,
        'type' => Product::REGULAR_PRODUCT['type'],
        'active' => 1,
        'weight' => '1KG',
        'description' => $faker->paragraph,
        'quantity' => 100,
        'gross_price' => 500,
        'vat' => 21,
    ];
});

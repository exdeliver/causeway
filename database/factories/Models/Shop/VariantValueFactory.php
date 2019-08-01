<?php

/** @var Factory $factory */
use Exdeliver\Causeway\Domain\Entities\Shop\ProductVariants\VariantValue;
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

$factory->define(VariantValue::class, function (Faker $faker) {
    return [
        'variant_value' => $faker->name,
        'sequence' => 0,
    ];
});

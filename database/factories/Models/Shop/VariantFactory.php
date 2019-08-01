<?php

/** @var Factory $factory */
use Exdeliver\Causeway\Domain\Entities\Shop\ProductVariants\ValueTypes;
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

$factory->define(\Exdeliver\Causeway\Domain\Entities\Shop\ProductVariants\Variant::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'value_type' => key(ValueTypes::TEXT),
        'sequence' => 0,
    ];
});

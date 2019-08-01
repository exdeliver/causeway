<?php

namespace Exdeliver\Causeway\Tests\Unit;

use Exdeliver\Causeway\Domain\Entities\Shop\Product;
use Exdeliver\Causeway\Tests\TestCase;
use Faker\Factory;

class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function create_product_and_verify_slug()
    {
        $faker = Factory::create();

        $title = $faker->name;

        $product = factory(Product::class)->create([
            'title' => $title,
            'slug' => str_slug($title),
        ]);

        $this->assertEquals($product->slug, str_slug($title));

        // start iterating by 1 because slugs wont be ever - 0
        for ($i = 1; $i <= 5; ++$i) {
            $product = factory(Product::class)->create([
                'title' => $title,
                'slug' => str_slug($title),
            ]);

            $product->title = $title;
            $product->slug = str_slug($title);
            $product->save();

            $this->assertEquals($product->slug, str_slug($title).'-'.($i + 1));
        }
    }
}

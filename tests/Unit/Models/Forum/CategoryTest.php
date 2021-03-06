<?php

namespace Exdeliver\Causeway\Tests\Unit;

use Exdeliver\Causeway\Domain\Entities\Forum\Category;
use Exdeliver\Causeway\Tests\TestCase;
use Faker\Factory;

class CategoryTest extends TestCase
{
    /**
     * @test
     */
    public function create_category_and_verify_slug()
    {
        $faker = Factory::create();

        $title = $faker->name;

        $thread = factory(Category::class)->create([
            'title' => $title,
            'slug' => str_slug($title),
        ]);

        $this->assertEquals($thread->slug, str_slug($title));

        // start iterating by 1 because slugs wont be ever - 0
        for ($i = 1; $i <= 5; ++$i) {
            $thread = factory(Category::class)->create([
                'title' => $title,
                'slug' => str_slug($title),
            ]);

            $this->assertEquals($thread->slug, str_slug($title).'-'.($i + 1));
        }
    }
}

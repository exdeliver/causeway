<?php

namespace Exdeliver\Causeway\Tests\Unit;

use Exdeliver\Causeway\Domain\Entities\Page\Page;
use Exdeliver\Causeway\Tests\TestCase;
use Faker\Factory;

class PageTest extends TestCase
{
    /**
     * @test
     */
    public function create_page_and_verify_slug()
    {
        $faker = Factory::create();

        $title = $faker->name;

        $thread = factory(Page::class)->create([
            'name' => $title,
            'slug' => str_slug($title),
        ]);

        $this->assertEquals($thread->slug, str_slug($title));

        // start iterating by 1 because slugs wont be ever - 0
        for ($i = 1; $i <= 5; $i++) {
            $thread = factory(Page::class)->create([
                'name' => $title,
                'slug' => str_slug($title),
            ]);

            $thread->translateOrNew('nl')->name = $title;
            $thread->translateOrNew('nl')->slug = str_slug($title);
            $thread->save();

            $threads = $thread->translations->toArray();

            $this->assertCount(2, $threads);

            $this->assertEquals($thread->slug, str_slug($title) . '-' . ($i + 1));
        }
    }
}

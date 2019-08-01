<?php

namespace Exdeliver\Causeway\Tests\Unit;

use Exdeliver\Causeway\Tests\TestCase;
use Faker\Factory;
use Tests\Helpers\ThreadFactory;

class ThreadTest extends TestCase
{
    /**
     * @test
     */
    public function create_thread_and_verify_slug()
    {
        $faker = Factory::create();

        $title = $faker->name;

        $thread = (new ThreadFactory())->create([
            'title' => $title,
            'slug' => str_slug($title),
        ]);

        $this->assertEquals($thread->slug, str_slug($title));

        // start iterating by 1 because slugs wont be ever - 0
        for ($i = 1; $i <= 5; ++$i) {
            $thread = (new ThreadFactory())->create([
                'title' => $title,
                'slug' => str_slug($title),
            ]);

            $this->assertEquals($thread->slug, str_slug($title).'-'.($i + 1));
        }
    }

    /**
     * @test
     */
    public function create_thread_with_and_count_replies()
    {
        $faker = Factory::create();
        $title = $faker->name;
        $replies = 10;

        $thread = (new ThreadFactory())
            ->withReplies($replies)
            ->create([
                'title' => $title,
                'slug' => str_slug($title),
            ]);

        $this->assertCount($replies, $thread->comments);
    }
}

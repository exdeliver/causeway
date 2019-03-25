<?php

namespace Exdeliver\Causeway\Tests\Helpers;

use Exdeliver\Causeway\Domain\Entities\Comment\Comment;
use Exdeliver\Causeway\Domain\Entities\Forum\Thread;
use Faker\Factory;

class ThreadFactory
{
    /** @var $replies */
    protected $replies;

    /**
     * @param array $params
     * @return mixed
     */
    public function create(array $params)
    {
        $faker = Factory::create();

        $thread = factory(Thread::class)->create($params);

        if (isset($this->replies) && count($this->replies)) {
            for ($i = 0; $i < $this->replies; $i++) {
                factory(Comment::class)->create([
                    'commentable_id' => $thread->id,
                    'commentable_type' => Thread::class,
                    'data' => json_encode([
                        'comment' => $faker->paragraph,
                        'profile_picture' => '/images/placeholder_profile.png',
                        'name' => $faker->name,
                    ]),
                ]);
            }
        }

        return $thread;
    }

    /**
     * @param integer $replies
     * @return ThreadFactory
     */
    public function withReplies(int $replies): ThreadFactory
    {
        $this->replies = $replies;
        return $this;
    }
}
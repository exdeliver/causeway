<?php

namespace Exdeliver\Causeway\Domain\Entities\Comment;

use Exdeliver\Causeway\Domain\Services\CommentService;
use Exdeliver\Causeway\Infrastructure\Repositories\CommentRepository;

/**
 * Trait CommentTrait
 * @package Domain\Entities\Comment
 */
trait CommentTrait
{
    /**
     * @return mixed
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->orderBy('created_at', 'desc');
    }

    /**
     * @param $object
     * @param $id
     * @param $data
     * @return array
     */
    public function commentOn($object, $id, $data)
    {
        $comment = new CommentService(new CommentRepository(new Comment()));

        return $comment->commentSubjectByTypeAndId($object, $id, $data);
    }
}

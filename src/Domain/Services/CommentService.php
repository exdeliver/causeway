<?php

namespace Exdeliver\Causeway\Domain\Services;

use App\Events\CommentNotificationCreated;
use App\Exceptions\CommentNotificationException;
use Exdeliver\Causeway\Infrastructure\Repositories\CommentRepository;

/**
 * Class PandaCommentService
 * @package Domain\Services
 */
class CommentService extends AbstractService
{
    /**
     * PandaCommentService constructor.
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->repository = $commentRepository;
    }

    /**
     * @param $type
     * @param string $id
     * @param array $data
     */
    public function commentSubjectByTypeAndId($type, string $id, array $data)
    {
        $comment = $this->repository->create([
            'commentable_id' => $id,
            'commentable_type' => get_class($type),
            'user_id' => auth()->user()->id,
            'data' => json_encode($data),
        ]);

        try {
            event(new CommentNotificationCreated($comment));
        } catch (CommentNotificationException $e) {
            report($e);
        }
    }
}
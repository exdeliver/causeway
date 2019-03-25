<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Comment\Comment;

/**
 * Class CommentRepository
 * @package Exdeliver\Causeway\Infrastructure\Repositories
 */
class CommentRepository extends AbstractRepository
{
    /**
     * GroupRepository constructor.
     * @param Comment $model
     */
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }
}
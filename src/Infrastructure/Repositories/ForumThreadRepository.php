<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Forum\Thread;

/**
 * Class ForumThreadRepository.
 */
class ForumThreadRepository extends AbstractRepository
{
    /**
     * PageRepository constructor.
     *
     * @param Thread $model
     */
    public function __construct(Thread $model)
    {
        parent::__construct($model);
    }
}

<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\User\User;

/**
 * Class UserRepository.
 */
class UserRepository extends AbstractRepository
{
    /**
     * GroupRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}

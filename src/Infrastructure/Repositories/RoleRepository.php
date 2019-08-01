<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Spatie\Permission\Models\Role;

/**
 * Class RoleRepository.
 */
class RoleRepository extends AbstractRepository
{
    /**
     * GroupRepository constructor.
     *
     * @param Role $model
     */
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }
}

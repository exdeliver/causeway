<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Spatie\Permission\Models\Permission;

/**
 * Class RoleRepository.
 */
class PermissionRepository extends AbstractRepository
{
    /**
     * GroupRepository constructor.
     *
     * @param Permission $model
     */
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }
}

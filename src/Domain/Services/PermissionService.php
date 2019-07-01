<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exdeliver\Causeway\Infrastructure\Repositories\PermissionRepository;

/**
 * Class PandaUserService
 *
 * @package Domain\Services
 */
final class PermissionService extends AbstractService
{
    /**
     * PandaUserService constructor.
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->repository = $permissionRepository;
    }
}

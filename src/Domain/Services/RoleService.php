<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exdeliver\Causeway\Infrastructure\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

/**
 * Class PandaUserService
 *
 * @package Domain\Services
 */
final class RoleService extends AbstractService
{
    /**
     * PandaUserService constructor.
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->repository = $roleRepository;
    }

    /**
     * @param array $match
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model|void
     */
    public function updateOrCreateWithPermissions(array $match, Request $request)
    {
        /** @var Role $role */
        $role = $this->updateOrCreate($match, $request->only([
            'name',
            'guard_name',
        ]));

        $role->syncPermissions($request->only(['permissions']));
    }
}

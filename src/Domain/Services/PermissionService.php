<?php

namespace Exdeliver\Causeway\Domain\Services;

use App\Exceptions\RegistrationException;
use Exdeliver\Causeway\Domain\Entities\User\User;
use Exdeliver\Causeway\Events\CausewayRegistered;
use Exdeliver\Causeway\Infrastructure\Repositories\PermissionRepository;
use Exdeliver\Causeway\Infrastructure\Repositories\RoleRepository;
use Exdeliver\Causeway\Infrastructure\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

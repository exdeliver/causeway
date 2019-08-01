<?php

namespace Exdeliver\Causeway\Tests\Helpers;

use Exception;
use Exdeliver\Causeway\Domain\Entities\User\User;
use Spatie\Permission\Models\Role;

/**
 * Class UserFactory.
 */
class UserFactory
{
    /**
     * @var Role
     */
    protected $role;

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function create(array $params)
    {
        $user = factory(User::class)->create($params);
        $user->assignRole($this->role);

        return $user;
    }

    /**
     * @param $role
     *
     * @return UserFactory
     *
     * @throws Exception
     */
    public function withRole($role): self
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->firstOrFail();
        }

        if ($role instanceof Role) {
            $this->role = $role;

            return $this;
        }

        throw new Exception('Well this is not a role sir...');
    }
}

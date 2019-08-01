<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exception;
use Exdeliver\Causeway\Domain\Entities\Group\Group;
use Exdeliver\Causeway\Domain\Entities\Group\GroupUser;
use Exdeliver\Causeway\Infrastructure\Repositories\GroupRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class GroupService.
 */
final class GroupService extends AbstractService
{
    /**
     * GroupService constructor.
     *
     * @param GroupRepository $groupRepository
     */
    public function __construct(GroupRepository $groupRepository)
    {
        $this->repository = $groupRepository;
    }

    /**
     * @param array $users
     * @param Group $group
     *
     * @return bool
     *
     * @throws Exception
     */
    public function addUsersToGroup(array $users, Group $group): bool
    {
        try {
            // Filter already existing users before adding to group.
            collect($users)->filter(function ($user) use ($group) {
                if (!$group->findUserInGroup($user['user_id'])) {
                    return true;
                }

                return false;
            })->each(function ($user) use ($group) {
                GroupUser::create([
                    'user_id' => $user['user_id'],
                    'panda_group_id' => $group->id,
                    'panda_group_role_id' => $user['role_id'],
                ]);

                $group->notify(new PandaGroupUserJoined($user['user_id'], $group->id));

                event(new PandaNewActivityCreated($group));
            });

            return true;
        } catch (Exception $e) {
            dd($e->getTraceAsString());
            throw new Exception('Could not add user to group');
        }
    }

    /**
     * @param array    $params
     * @param int|null $id
     *
     * @return Group
     */
    public function saveGroup(array $params, int $id = null): PandaGroup
    {
        if (null !== $id) {
            return $this->update($id, $params);
        } else {
            $params['uuid'] = Str::uuid();

            return $this->create($params);
        }
    }

    /**
     * @param $label
     *
     * @return mixed
     */
    public function getGroupByLabel($label)
    {
        return $this->repository->getGroupByLabel($label)->firstOrFail();
    }

    /**
     * @param $label
     * @param $uuid
     *
     * @return mixed
     */
    public function getGroupByLabelAndUuid($label, $uuid)
    {
        return $this->repository->findByUuid($uuid)->getGroupByLabel($label)->firstOrFail();
    }

    /**
     * @param $label
     *
     * @return mixed|void
     */
    public function getGroupByLabelAndAuthenticatedUser($label)
    {
        $group = $this->repository->getGroupByLabel($label)->firstOrFail();

        if (false === $group->findUserById(auth()->user()->id)) {
            return abort(404);
        }

        return $group;
    }

    /**
     * @return mixed
     */
    public function groupsByAuthenticatedUser()
    {
        return $this->repository->groupsByAuthenticatedUser();
    }

    /**
     * @param PandaGroup $group
     *
     * @throws Exception
     */
    public function deleteGroupAndUsers(PandaGroup $group): void
    {
        $this->deleteUsersFromGroup($group);

        $group->delete();
    }

    /**
     * @param PandaGroup $group
     * @param array|null $users
     */
    public function deleteUsersFromGroup(PandaGroup $group, array $users = null)
    {
        $group = $group->users();

        if (isset($users) && count($users) > 0) {
            $group = $group->whereIn('user_id', $users);
        }

        $group->delete();
    }

    /**
     * @param int        $userId
     * @param Collection $groups
     */
    public function clearPointsByUser(int $userId, Collection $groups): void
    {
        foreach ($groups as $groupUser) {
            $group = $this->repository->find($groupUser->panda_group_id);
            if (isset($group)) {
                $group->notify(new PandaPointReset($userId, $groupUser->group->id));
            }
        }

        $points = PandaUserPoint::where('user_id', $userId)->get();

        foreach ($points as $point) {
            $point->delete();
        }

        // Create a 0 point to keep track of last time you did something.
        PandaUserPoint::create([
            'user_id' => $userId,
            'amount' => 0,
        ]);
    }
}

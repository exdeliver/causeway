<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Group\Group;

/**
 * Class GroupRepository
 * @package Exdeliver\Causeway\Infrastructure\Repositories
 */
class GroupRepository extends AbstractRepository
{
    /**
     * GroupRepository constructor.
     * @param Group $model
     */
    public function __construct(Group $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $label
     * @return $this
     */
    public function getGroupByLabel(string $label): self
    {
        $this->model = $this->model->where('label', '=', $label);
        return $this;
    }

    /**
     * @return mixed
     */
    public function groupsByAuthenticatedUser()
    {
        $this->model = $this->model
            ->select(['_groups.*', '_groups_users._group_id as _group_id'])
            ->join('_groups_users', function ($join) {
                $join->on('_groups_users._group_id', '=', '_groups.id');
            })->where('_groups_users.user_id', '=', auth()->user()->id)
            ->groupBy('_groups.id');

        return $this;
    }

    /**
     * @param string $uuid
     * @return GroupRepository
     */
    public function findByUuid(string $uuid): self
    {
        $this->model = $this->model->where('uuid', $uuid);
        return $this;
    }
}
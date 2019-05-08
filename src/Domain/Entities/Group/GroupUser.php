<?php

namespace Exdeliver\Causeway\Domain\Entities\Group;

use Exdeliver\Causeway\Domain\Entities\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class GroupUser
 * @package Domain\Entities\Group
 */
class GroupUser extends Pivot
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = '_groups_users';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(new User());
    }

    /**
     * @return BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(new Group(), '_group_id', 'id');
    }
}

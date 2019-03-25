<?php

namespace Exdeliver\Causeway\Domain\Entities\Group;

use Exdeliver\Causeway\Domain\Common\Entity;

/**
 * Class GroupRole
 *
 * @package Domain\Entities\Group
 */
class GroupRole extends Entity
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['name', 'label'];
}
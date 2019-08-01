<?php

namespace Exdeliver\Causeway\Domain\Entities\Group;

use Exdeliver\Causeway\Domain\Common\Entity;

/**
 * Class GroupRole.
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

<?php

namespace Exdeliver\Causeway\Domain\Entities\User;

use Exdeliver\Causeway\Domain\Common\Entity;

/**
 * Class UserPoint
 * @package Domain\Entities\User
 */
class UserPoint extends Entity
{
    /**
     * Mass assign variables.
     *
     * @var array
     */
    protected $fillable = ['amount', 'user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(new User());
    }
}
<?php

namespace Exdeliver\Causeway\Domain\Entities\User;

use Exdeliver\Causeway\Domain\Common\Entity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class UserPoint.
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
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(new User());
    }
}

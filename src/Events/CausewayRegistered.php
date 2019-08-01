<?php

namespace Exdeliver\Causeway\Events;

use Exdeliver\Causeway\Domain\Entities\User\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Queue\SerializesModels;

/**
 * Class CausewayRegistered.
 */
final class CausewayRegistered
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var Authenticatable
     */
    public $user;

    /**
     * CausewayRegistered constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

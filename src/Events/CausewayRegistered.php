<?php

namespace Exdeliver\Causeway\Events;

use Exdeliver\Causeway\Domain\Entities\User\User;
use Illuminate\Queue\SerializesModels;

/**
 * Class CausewayRegistered
 * @package Exdeliver\Causeway\Events
 */
class CausewayRegistered
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * CausewayRegistered constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

<?php

namespace Exdeliver\Causeway\Listeners;

use Exdeliver\Causeway\Events\CausewayRegistered;
use Exdeliver\Causeway\Notifications\RegisterVerification;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class AccountVerificationNotification.
 */
class AccountVerificationNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * @param CausewayRegistered $event
     */
    public function handle(CausewayRegistered $event)
    {
        $event->user->notify(new RegisterVerification());
    }
}

<?php

namespace App\Policies;

use Exdeliver\Causeway\Domain\Entities\User\User;

class PagePolicy
{
    /**
     * Determine if the given post can be updated by the user.
     *
     * @param User $user
     *
     * @return bool
     */
    public function update(User $user)
    {
        return true;
        //return $user->id === $post->user_id;
    }
}

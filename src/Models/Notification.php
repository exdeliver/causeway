<?php

namespace Exdeliver\Causeway\Models;

use Exdeliver\Causeway\Domain\Entities\Comment\Comment;
use Illuminate\Notifications\DatabaseNotification;
use Rennokki\Befriended\Contracts\Likeable;
use Rennokki\Befriended\Traits\CanBeLiked;

/**
 * Class Notification
 * @package App\Models
 */
class Notification extends DatabaseNotification implements Likeable
{
    use CanBeLiked;

    /**
     * @return mixed
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->orderBy('created_at', 'desc');
    }
}

<?php

namespace Exdeliver\Causeway\Domain\Entities\User;

use Exdeliver\Causeway\Domain\Entities\Comment\CommentTrait;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Spatie\Permission\Traits\HasRoles;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Trait UserTrait.
 */
trait UserTrait
{
    use HasRoles;
    use CommentTrait;

    /**
     * Get ecnrypted userID.
     *
     * @return string
     */
    public function getEncryptedUserIdAttribute(): string
    {
        return Hashids::encode($this->id);
    }

    /**
     * @return hasMany
     */
    public function points()
    {
        return $this->hasMany(new UserPoint(), 'user_id');
    }

    /**
     * Get profile picture.
     *
     * @return string
     */
    public function getProfilePictureAttribute()
    {
        return 'placeholder_profile.png';
    }

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn(): string
    {
        return 'users.'.$this->id;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
}

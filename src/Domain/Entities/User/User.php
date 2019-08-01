<?php

namespace Exdeliver\Causeway\Domain\Entities\User;

use Exdeliver\Causeway\Domain\Entities\Group\GroupUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable;
use Rennokki\Befriended\Contracts\Liker;
use Rennokki\Befriended\Traits\CanLike;

/**
 * Class User.
 */
class User extends Authenticatable implements Liker, MustVerifyEmail, \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable;
    use UserTrait;
    use CanLike;
    use Notifiable;

    /**
     * @var string
     */
    protected $guard_name = 'web';

    /**
     * Database table.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return HasMany
     */
    public function groups()
    {
        return $this->hasMany(new GroupUser(), 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function points()
    {
        return $this->hasMany(new UserPoint(), 'user_id', 'id');
    }
}

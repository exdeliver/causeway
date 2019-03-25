<?php

namespace Exdeliver\Causeway\Domain\Entities\User;

use Exdeliver\Causeway\Domain\Entities\Group\GroupUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Rennokki\Befriended\Contracts\Liker;
use Rennokki\Befriended\Traits\CanLike;

/**
 * Class User
 * @package Domain\Entities\User
 */
class User extends Authenticatable implements Liker, MustVerifyEmail
{
    use UserTrait, CanLike, Notifiable;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups()
    {
        return $this->hasMany(new GroupUser(), 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function points()
    {
        return $this->hasMany(new UserPoint(), 'user_id', 'id');
    }
}
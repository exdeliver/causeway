<?php

namespace Exdeliver\Causeway\Domain\Entities\Group;

use App\Models\Notification;
use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Exdeliver\Causeway\Domain\Entities\Comment\CommentTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * Class Group.
 */
class Group extends AggregateRoot
{
    use Notifiable;
    use CommentTrait;
    use SoftDeletes;

    /**
     * Mass assign variables.
     *
     * @var array
     */
    protected $fillable = ['name', 'label', 'uuid'];

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = '_groups';

    /**
     * @param int $id
     *
     * @return bool
     */
    public function findUserById(int $id): bool
    {
        return $this->users->contains('user_id', $id);
    }

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(new GroupUser());
    }

    /**
     * Set the label value.
     *
     * @param $value
     */
    public function setLabelAttribute($value): void
    {
        if (isset($value)) {
            if ($value !== $this->label) {
                // Set slug
                $this->attributes['label'] = $this->generateIteratedName('label', $value);
            }
        } else {
            // Otherwise empty the slug
            $this->attributes['label'] = null;
        }
    }

    /**
     * Find user in current group.
     *
     * @param int $userId
     *
     * @return bool
     */
    public function findUserInGroup(int $userId)
    {
        return in_array($userId, array_column($this->users->toArray(), 'user_id'), true);
    }

    /**
     * Notifications.
     *
     * @return MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    /**
     * @return int
     */
    public function getWeeksCountPointsAttribute(): int
    {
        return 4;
    }
}

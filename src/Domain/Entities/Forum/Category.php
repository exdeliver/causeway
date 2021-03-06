<?php

namespace Exdeliver\Causeway\Domain\Entities\Forum;

use Exception;
use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Exdeliver\Causeway\Domain\Common\ChildrenTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Thread.
 */
class Category extends AggregateRoot
{
    use ChildrenTrait;

    /**
     * @var string
     */
    protected $table = 'forum_categories';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $appends = ['json_children', 'fqn_slug', 'latest_replied_thread_link', 'latest_replied_thread_title', 'latest_replied_user', 'latest_replied_date', 'count_threads', 'count_replies'];

    /**
     * @param $id
     *
     * @return Model
     */
    public static function findNext($id)
    {
        return static::where('id', '>', $id)->first();
    }

    /**
     * @param $id
     *
     * @return Model
     */
    public static function findPrevious($id)
    {
        return static::where('id', '<', $id)->first();
    }

    /**
     * Set the slug value.
     *
     * @param $value
     */
    public function setSlugAttribute($value): void
    {
        if (isset($value)) {
            if ($value !== $this->slug) {
                // Set slug
                $this->attributes['slug'] = $this->generateIteratedName('slug', $value);
            }
        } else {
            // Otherwise empty the slug
            $this->attributes['slug'] = null;
        }
    }

    /**
     * @return string
     */
    public function getFqnSlugAttribute()
    {
        return route('site.forum.category', ['id' => $this->attributes['slug']]);
    }

    /**
     * @return int
     */
    public function getCountThreadsAttribute()
    {
        return count($this->threads);
    }

    /**
     * @return int
     */
    public function getCountRepliesAttribute()
    {
        return $this->threads()->withCount('comments')->get()->sum('comments_count');
    }

    /**
     * @return HasMany
     */
    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }

    /**
     * @return Model|HasMany|object|null
     */
    public function getLatestRepliedThreadAttribute()
    {
        return $this->threads()->orderBy('created_at', 'asc')->first();
    }

    /**
     * @return |null
     */
    public function getLatestRepliedThreadTitleAttribute()
    {
        return $this->latest_replied_thread->title ?? null;
    }

    /**
     * @return string|null
     */
    public function getLatestRepliedThreadLinkAttribute()
    {
        if (isset($this->latest_replied_thread->slug)) {
            return route('site.forum.thread', ['forumCategory' => $this->slug, 'forumThread' => $this->latest_replied_thread->slug]);
        }

        return null;
    }

    /**
     * @return |null
     */
    public function getLatestRepliedUserAttribute()
    {
        return $this->latest_replied_thread->user->name ?? null;
    }

    /**
     * @return |null
     */
    public function getLatestRepliedDateAttribute()
    {
        try {
            return $this->latest_replied_thread->created_at->format('d-m-Y H:i') ?? null;
        } catch (Exception $e) {
            return null;
        }
    }
}

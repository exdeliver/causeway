<?php

namespace Exdeliver\Causeway\Domain\Entities\Forum;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Thread
 * @package Domain\Entities\Forum
 */
class Category extends AggregateRoot
{
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
    protected $appends = ['json_children', 'fqn_slug', 'count_threads', 'count_replies'];

    /**
     * @param $id
     * @return Model
     */
    public static function findNext($id)
    {
        return static::where('id', '>', $id)->first();
    }

    /**
     * @param $id
     * @return Model
     */
    public static function findPrevious($id)
    {
        return static::where('id', '<', $id)->first();
    }

    /**
     * @return false|string
     */
    public function getJsonChildrenAttribute()
    {
        return json_encode($this->children->toArray(), true);
    }

    /**
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->orderBy('sequence', 'asc');
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
     * @param Builder $query
     * @return Builder
     */
    public function scopeGetParents(Builder $query)
    {
        $query->whereNull('parent_id');

        return $query;
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Thread::class);
    }
}
<?php

namespace Exdeliver\Causeway\Domain\Common;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Trait ChildrenTrait.
 */
trait ChildrenTrait
{
    /**
     * @var string
     */
    protected $foreignKey = 'parent_id';

    /**
     * @param string $foreignKey
     */
    public function setChildForeignKey(string $foreignKey)
    {
        $this->foreignKey = $foreignKey;
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
        return $this->hasMany(self::class, $this->getChildForeignKey(), 'id')->orderBy('sequence', 'asc');
    }

    /**
     * @return string
     */
    protected function getChildForeignKey()
    {
        return $this->foreignKey;
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeGetParents(Builder $query)
    {
        $query->whereNull($this->getChildForeignKey());

        return $query;
    }
}

<?php

namespace Exdeliver\Causeway\Domain\Entities\Menu;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Menu
 * @package Domain\Entities\Menu
 */
class Menu extends AggregateRoot
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(MenuItem::class)->orderBy('sequence', 'asc');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeGetParents(Builder $query)
    {
        $query->whereHas('items', function (Builder $query) {
            return $query->whereNull('access_level')
                ->whereNUll('parent_id')
                ->orderBy('sequence');
        })
            ->with(['items' => function (HasMany $query) {
                return $query->whereNull('access_level')
                    ->whereNUll('parent_id')
                    ->orderBy('sequence');
            }]);

        return $query;
    }
}

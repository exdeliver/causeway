<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter implements FilterContract
{
    public const DEFAULT_FILTERS = [
        'title' => ['title' => 'Title', 'type' => 'search', 'sequence' => 0],
        'price' => ['title' => 'Price', 'type' => 'priceRange', 'sequence' => 1],
//        'gross_price' => ['title' => 'Gross price', 'type' => 'priceRange', 'sequence' => 2],
    ];

    /**
     * @var Builder $builder
     */
    protected $builder;

    /**
     * @param string $column
     * @param $value
     * @param Builder $query
     * @return $this
     */
    public function performQuery(string $column, $value, Builder $query): Builder
    {
        return $query->where($column, $value);
    }
}
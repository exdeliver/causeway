<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

abstract class AbstractFilter implements FilterContract
{
    public const DEFAULT_FILTERS = [
        'title' => 'search',
        'description' => 'search',
        'price' => 'priceRange',
        'gross_price' => 'priceRange',
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

    /**
     * @param $params
     * @return View
     */
    public function render($params): View
    {
        return view('site::shop.partials.category.filters.text', $params);
    }
}
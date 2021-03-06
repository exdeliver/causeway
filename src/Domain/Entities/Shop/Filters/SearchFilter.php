<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class SearchFilter extends AbstractFilter
{
    /**
     * @param string $column
     * @param $value
     * @param Builder $query
     * @return $this
     */
    public function performQuery(string $column, $value, Builder $query): Builder
    {
        return $query->where($column, 'LIKE', '%' . $value . '%');
    }

    /**
     * @param $params
     * @return View
     */
    public function render(array $params): View
    {
        return view('site::shop.partials.category.filters.text', $params);
    }
}

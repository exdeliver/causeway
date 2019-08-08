<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class DateTimeRangeFilter extends AbstractFilter
{
    /**
     * @param string $column
     * @param $value
     * @param Builder $query
     * @return Builder
     */
    public function performQuery(string $column, $value, Builder $query): Builder
    {
        $values = explode(',', $value);

        if (!isset($values[1])) {
            $values[1] = $values[0];
            $values[0] = 0;
        }

        return $query->whereBetween($column, $values);
    }

    /**
     * @param $params
     * @return View
     */
    public function render(array $params): View
    {
        return view('site::shop.partials.category.filters.date-time-range', $params);
    }
}

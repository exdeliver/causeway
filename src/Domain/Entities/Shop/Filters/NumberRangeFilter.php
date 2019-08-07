<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class NumberRangeFilter extends AbstractFilter
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
        return $query->whereBetween($column, $values);
    }
}

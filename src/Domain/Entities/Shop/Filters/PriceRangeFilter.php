<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class PriceRangeFilter extends AbstractFilter
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
        $values[0] *= 100;
        $values[1] *= 100;

        return $query->groupBy('shop_products.id')->havingBetween($column, $values);
    }
}

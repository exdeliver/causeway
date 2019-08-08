<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Filters;

use Illuminate\View\View;

class BooleanFilter extends AbstractFilter
{
    /**
     * @param $params
     * @return View
     */
    public function render(array $params): View
    {
        return view('site::shop.partials.category.filters.checkbox', $params);
    }
}

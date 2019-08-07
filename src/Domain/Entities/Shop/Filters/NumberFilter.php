<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Filters;

use Illuminate\View\View;

class NumberFilter extends AbstractFilter
{
    public function render($params): View
    {
        return view('site::shop.partials.category.filters.text');
    }
}

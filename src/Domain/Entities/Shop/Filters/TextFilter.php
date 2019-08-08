<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Filters;

use Illuminate\View\View;

class TextFilter extends AbstractFilter
{
    /**
     * @param $params
     * @return View
     */
    public function render(array $params): View
    {
        return view('site::shop.partials.category.filters.text', $params);
    }
}

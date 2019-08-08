<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

interface FilterContract
{
    public function performQuery(string $column, $value, Builder $query);


    /**
     * @param $params
     * @return View
     */
    public function render(array $params);
}

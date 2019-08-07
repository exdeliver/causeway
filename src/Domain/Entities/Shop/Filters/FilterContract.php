<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterContract
{
    public function performQuery(string $column, $value, Builder $query);
}

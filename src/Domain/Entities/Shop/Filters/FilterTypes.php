<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Filters;

/**
 * Class FilterTypes.
 */
class FilterTypes
{
    public const text = TextFilter::class;
    public const search = SearchFilter::class;
    public const dropdown = SelectFilter::class;
    public const slider = NumberRangeFilter::class;
    public const priceRange = PriceRangeFilter::class;
    public const checkbox = BooleanFilter::class;
    public const number = NumberFilter::class;

    public const FILTER_TYPES = [
        'text' => 'Text field',
        'search' => 'Search field',
        'dropdown' => 'Dropdown',
        'slider' => 'Slider',
        'priceRange' => 'Price range',
        'number' => 'Number',
        'checkbox' => 'Checkbox',
    ];
}

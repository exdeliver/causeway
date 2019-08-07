<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Filters;

use Exdeliver\Causeway\Domain\Entities\Shop\ProductAttributes\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use ReflectionClass;

class QueryBuilder
{
    /**
     * @var Builder
     */
    protected $query;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var
     */
    protected $filters;

    /**
     * QueryBuilder constructor.
     * @param Request $request
     * @param Builder $builder
     * @throws \ReflectionException
     */
    public function __construct(Request $request, Builder $builder)
    {
        $this->query = $builder;
        $this->request = $request;

        $availableFilters = Attribute::select(['slug', 'value_type'])
            ->get()
            ->pluck('value_type', 'slug')
            ->merge(AbstractFilter::DEFAULT_FILTERS)
            ->toArray();

        $filterTypes = new ReflectionClass(FilterTypes::class);

        // Save typed queries in array.
        $queries = [];

        // Loop through all available filters
        foreach ($availableFilters as $filterName => $availableFilter) {
            // Get the filter type name
            $filterTypeFQDN = $filterTypes->getConstant($availableFilters[$filterName]);

            /** @var AbstractFilter $filter */
            $filterTypeFQDN = new $filterTypeFQDN;
            $value = $this->request->filters[$filterName] ?? null;

            // Perform query if is set in the request
            if (isset($this->request->filters[$filterName]) && !empty($value)) {
                $queries[] = $filterTypeFQDN->performQuery($filterName, $value, $this->query);
            }

            // Render view and add to filters array to display on category page.
            $this->filters[] = $filterTypeFQDN->render(['name' => $filterName, 'value' => $value]);
        }

        // Append queries
        foreach ($queries as $query) {
            $this->query = $query;
        }
    }

    /**
     * Return active filters.
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @return Builder
     */
    public function getQuery()
    {
        return $this->query;
    }
}

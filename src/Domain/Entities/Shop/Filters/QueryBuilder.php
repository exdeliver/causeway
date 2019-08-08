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

        $availableFilters = collect(Attribute::with('values')->get()
                ->mapWithKeys(function ($item) {
                    return [
                        $item->slug => [
                            'title' => $item->name, 'type' => $item->value_type, 'values' => $item->values],
                    ];
                })
                ->toArray() + AbstractFilter::DEFAULT_FILTERS)->sortBy('sequence')->toArray();

        $filterTypes = new ReflectionClass(FilterTypes::class);

        // Save typed queries in array.
        $queries = [];

        // Loop through all available filters
        foreach ($availableFilters as $filterName => $availableFilter) {
            // Get the filter type name
            $filterTypeFQDN = $filterTypes->getConstant($availableFilters[$filterName]['type']);

            /** @var AbstractFilter $filter */
            $filterTypeFQDN = new $filterTypeFQDN;
            $value = $this->request->filters[$filterName] ?? null;

            // Perform query if is set in the request
            if (isset($this->request->filters[$filterName]) && !empty($value)) {
                $queries[] = $filterTypeFQDN->performQuery($filterName, $value, $this->query);
            }

            // Render view and add to filters array to display on category page.
            $this->filters[] = $filterTypeFQDN->render([
                'title' => $availableFilter['title'],
                'name' => $filterName,
                'value' => $value,
                'data' => $availableFilters[$filterName]['values'] ?? null,
            ]);
        }

        // Append queries
        foreach ($queries as $query) {
            $this->query = $query;
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getFilters()
    {
        return collect($this->filters);
    }

    /**
     * @return Builder
     */
    public function getQuery()
    {
        return $this->query;
    }
}

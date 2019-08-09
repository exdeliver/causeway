<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Filters;

use Exdeliver\Causeway\Domain\Entities\Shop\ProductAttributes\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use ReflectionClass;

final class QueryBuilder
{
    /**
     * @var array
     */
    protected $queries = [];

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

        // Loop through all available filters
        foreach ($availableFilters as $filterName => $availableFilter) {
            // Get the filter type name
            $filterTypeFQDN = $filterTypes->getConstant($availableFilters[$filterName]['type']);

            /** @var AbstractFilter $filter */
            $filterTypeFQDN = new $filterTypeFQDN;
            $value = $this->request->filters[$filterName] ?? null;

            // Perform query if is set in the request
            if (isset($this->request->filters[$filterName]) && !empty($value)) {
                $this->queries[] = $filterTypeFQDN->performQuery($filterName, $value, $this->query);
            }

            // Render view and add to filters array to display on category page.
            $this->filters[] = $filterTypeFQDN->render([
                'title' => $availableFilter['title'],
                'name' => $filterName,
                'value' => $value,
                'data' => $availableFilters[$filterName]['values'] ?? null,
            ]);
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
        $columns = [
            'shop_products.id',
            'shop_products.parent_product_id',
            'shop_products.title',
            'shop_products.slug',
            'shop_products.type',
            'shop_products.active',
            'shop_products.description',
            'shop_products.quantity',
            'shop_products.gross_price',
            'shop_products.special_price',
            'shop_products.vat',
            'shop_products.pid',
            'shop_products.weight',
            'shop_products.sequence',
            'shop_products.created_at',
            'shop_products.updated_at',
        ];

        // Append queries
        if (count($this->queries) > 0) {
            foreach ($this->queries as $query) {
                $this->query = $query;
            }
            return $this->query
                ->groupBy($columns);
        }

        return $this->query;
    }
}

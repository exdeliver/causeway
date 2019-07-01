<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exdeliver\Causeway\Domain\Entities\Shop\Category;
use Exdeliver\Causeway\Domain\Entities\Shop\Product;
use Exdeliver\Causeway\Infrastructure\Repositories\ShopProductRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class ShopProductService
 */
final class ShopProductService extends AbstractService
{
    /**
     * @var array
     */
    protected $availableFilters = ['price', 'title'];

    /**
     * @var array
     */
    protected $filters;

    /**
     * ShopProductService constructor.
     * @param ShopProductRepository $shopProductRepository
     */
    public function __construct(ShopProductRepository $shopProductRepository)
    {
        $this->repository = $shopProductRepository;
    }

    /**
     * @param array $params
     * @param int|null $id
     * @return Model
     */
    public function saveProduct(array $params, int $id = null)
    {
        if ($id !== null) {
            return $this->update($id, $params);
        }

        $params['uuid'] = Str::uuid();
        return $this->create($params);
    }

    /**
     * @param Category $shopCategory
     * @param Request $request
     * @return \Illuminate\Database\Query\Builder
     */
    public function queryProducts(Category $shopCategory, Request $request)
    {
        $products = Product::whereIn('id', $shopCategory->products->pluck('product_id')->toArray());

        $products = $this->filter($request, $products, $shopCategory);

        return $products;
    }

    /**
     * Filtering.
     *
     * @param Request $request
     * @param Builder $products
     * @param Category $category
     * @return Builder
     */
    public function filter(Request $request, Builder $products, Category $category)
    {
        $categoryFilters = $category;

        $this->filters = [];
        if ($request->filter !== null) {
            foreach ($request->filter as $filterName => $value) {
                $this->filters['filter'][$filterName] = $value;

                if (in_array($filterName, $this->availableFilters)) {
                    $value = explode(',', $value);
                    if (!is_array($value)) {
                        $products->where($filterName, 'LIKE', '%' . $value . '%');
                    } else {
                        $products->where($filterName, 'LIKE', '%' . $value[0] . '%');
                        unset($value[0]);
                        foreach ($value as $val) {
                            $products->orWhere($filterName, 'LIKE', '%' . $val . '%');
                        }
                    }
                }
            }
        }

        return $products;
    }

    /**
     * Return active filters.
     *
     * @return array
     */
    public function getActiveFilters()
    {
        return $this->filters !== null ? $this->filters : [];
    }
}
<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exdeliver\Causeway\Domain\Entities\Shop\Category;
use Exdeliver\Causeway\Domain\Entities\Shop\Product;
use Exdeliver\Causeway\Infrastructure\Repositories\ShopProductRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ShopProductService.
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
     *
     * @param ShopProductRepository $shopProductRepository
     */
    public function __construct(ShopProductRepository $shopProductRepository)
    {
        $this->repository = $shopProductRepository;
    }

    /**
     * @param array $params
     * @param int|null $id
     *
     * @return Model
     */
    public function saveProduct(array $params, int $id = null)
    {
        if (null !== $id) {
            return $this->update($id, $params);
        }

        return $this->create($params);
    }

    /**
     * @param Category $shopCategory
     * @param Request $request
     *
     * @return \Illuminate\Database\Query\Builder
     * @throws \ReflectionException
     */
    public function queryProducts(Category $shopCategory, Request $request)
    {
        $products = Product::select(
            '*',
            DB::raw('IF(special_price IS NOT NULL AND special_price < gross_price, special_price, gross_price) * ((vat/100)+1) as price')
        )
            ->whereIn('id', $shopCategory->products->pluck('product_id')->toArray());

        return $products;
    }
}

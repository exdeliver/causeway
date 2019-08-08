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
            DB::raw('IF(shop_products.special_price IS NOT NULL AND shop_products.special_price < shop_products.gross_price, shop_products.special_price, shop_products.gross_price) * ((vat/100)+1) as price')
        )
            ->groupBy([
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
            ])
            ->whereIn('id', $shopCategory->products->pluck('product_id')->toArray());

        return $products;
    }
}

<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Shop\Product;

/**
 * Class ShopProductRepository
 * @package Exdeliver\Causeway\Infrastructure\Repositories
 */
class ShopProductRepository extends AbstractRepository
{
    /**
     * ShopProductRepository constructor.
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
}

<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Shop\Product;

/**
 * Class ShopProductRepository.
 */
class ShopProductRepository extends AbstractRepository
{
    /**
     * ShopProductRepository constructor.
     *
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
}

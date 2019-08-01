<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Shop\ProductVariants\Variant;

/**
 * Class ShopProductVariantRepository.
 */
class ShopProductVariantRepository extends AbstractRepository
{
    /**
     * ShopProductRepository constructor.
     *
     * @param Variant $model
     */
    public function __construct(Variant $model)
    {
        parent::__construct($model);
    }
}

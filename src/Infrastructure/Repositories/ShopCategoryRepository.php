<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Shop\Category;

/**
 * Class ShopCategoryRepository.
 */
class ShopCategoryRepository extends AbstractRepository
{
    /**
     * ShopCategoryRepository constructor.
     *
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
}

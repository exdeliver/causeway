<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Forum\Category;
use Exdeliver\Causeway\Domain\Entities\Menu\Menu;

/**
 * Class ForumCategoryRepository.
 */
class ForumCategoryRepository extends AbstractRepository
{
    /**
     * PageRepository constructor.
     *
     * @param Menu $model
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
}

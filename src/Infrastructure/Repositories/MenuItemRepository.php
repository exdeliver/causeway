<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Menu\MenuItem;

/**
 * Class MenuItemRepository.
 */
class MenuItemRepository extends AbstractRepository
{
    /**
     * PageRepository constructor.
     *
     * @param MenuItem $model
     */
    public function __construct(MenuItem $model)
    {
        parent::__construct($model);
    }
}

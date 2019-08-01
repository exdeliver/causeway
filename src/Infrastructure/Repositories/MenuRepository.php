<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Menu\Menu;

/**
 * Class MenuRepository.
 */
class MenuRepository extends AbstractRepository
{
    /**
     * PageRepository constructor.
     *
     * @param Menu $model
     */
    public function __construct(Menu $model)
    {
        parent::__construct($model);
    }
}

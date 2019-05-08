<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Page\Page;

/**
 * Class PageRepository
 * @package Exdeliver\Causeway\Infrastructure\Repositories
 */
class PageRepository extends AbstractRepository
{
    /**
     * PageRepository constructor.
     * @param Page $model
     */
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }
}

<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Shop\Orders\Order;

/**
 * Class OrderRepository
 * @package Exdeliver\Causeway\Infrastructure\Repositories
 */
class OrderRepository extends AbstractRepository
{
    /**
     * OrderRepository constructor.
     * @param Order $model
     */
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }
}

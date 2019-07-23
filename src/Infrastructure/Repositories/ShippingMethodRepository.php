<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Shop\ShippingMethods\ShippingMethods;

/**
 * Class ShippingMethodRepository
 * @package Exdeliver\Causeway\Infrastructure\Repositories
 */
class ShippingMethodRepository extends AbstractRepository
{
    /**
     * GroupRepository constructor.
     * @param ShippingMethods $model
     */
    public function __construct(ShippingMethods $model)
    {
        parent::__construct($model);
    }
}

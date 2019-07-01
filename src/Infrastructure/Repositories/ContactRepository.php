<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Shop\Customers\Contact;

/**
 * Class ContactRepository
 * @package Exdeliver\Causeway\Infrastructure\Repositories
 */
class ContactRepository extends AbstractRepository
{
    /**
     * ContactRepository constructor.
     * @param Contact $model
     */
    public function __construct(Contact $model)
    {
        parent::__construct($model);
    }
}

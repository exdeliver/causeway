<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Event\CalendarItem;

/**
 * Class EventRepository
 * @package Exdeliver\Causeway\Infrastructure\Repositories
 */
class EventRepository extends AbstractRepository
{
    /**
     * GroupRepository constructor.
     * @param CalendarItem $model
     */
    public function __construct(CalendarItem $model)
    {
        parent::__construct($model);
    }
}
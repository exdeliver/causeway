<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exdeliver\Causeway\Infrastructure\Repositories\EventRepository;

/**
 * Class EventService
 * @package Domain\Services
 */
final class EventService extends AbstractService
{
    /**
     * PhotoAlbumService constructor.
     * @param EventRepository $eventRepository
     */
    public function __construct(EventRepository $eventRepository)
    {
        $this->repository = $eventRepository;
    }

    /**
     * @param array $params
     * @param int|null $id
     * @return mixed
     */
    public function saveEvent(array $params, int $id = null)
    {
        return $this->updateOrCreate([
            'id' => $id,
        ], $params);
    }
}

<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exdeliver\Causeway\Infrastructure\Repositories\PhotoRepository;
use Illuminate\Support\Str;

/**
 * Class PhotoService
 * @package Domain\Services
 */
class PhotoService extends AbstractService
{
    /**
     * PhotoService constructor.
     * @param PhotoRepository $repository
     */
    public function __construct(PhotoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $params
     * @param int|null $id
     * @return mixed
     */
    public function savePhoto(array $params, int $id = null)
    {
        if ($id !== null) {
            return $this->update($id, $params);
        } else {
            $params['uuid'] = Str::uuid();
            return $this->create($params);
        }
    }
}
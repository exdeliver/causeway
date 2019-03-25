<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exdeliver\Causeway\Infrastructure\Repositories\AbstractRepository;

/**
 * Class AbstractService
 * @package Domain\Services
 */
abstract class AbstractService
{
    /**
     * @var AbstractRepository
     */
    public $repository;

    /**
     * @param array $params
     * @return mixed
     */
    public function create(array $params)
    {
        $entity = $this->repository->create($params);

        $entity->save();

        return $entity;
    }

    /**
     * @param int $id
     * @param array $params
     * @return mixed
     */
    public function update(int $id, array $params)
    {
        $entity = $this->repository->update($params, $id);

        $entity->save();

        return $entity;
    }

    public function updateOrCreate(array $match, array $params)
    {
        $entity = $this->repository->updateOrCreate($match, $params);

        $entity->save();

        return $entity;
    }

    /**
     * @param int $id
     */
    public function remove(int $id)
    {
        $this->delete($id);
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $this->repository->delete($id);
    }
}
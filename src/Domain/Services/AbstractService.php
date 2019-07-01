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

    /**
     * @param array $params
     * @param int|null $id
     * @return mixed
     */
    public function save(array $params, int $id = null)
    {
        if ($id !== null) {
            return $this->update($id, $params);
        }

        return $this->create($params);
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
}

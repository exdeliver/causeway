<?php

namespace Exdeliver\Causeway\Domain\Contracts\Repository;

/**
 * Interface AbstractRepositoryInterface
 * @package Domain\Contracts\Repository
 */
interface AbstractRepositoryInterface
{
    /**
     * @return int
     */
    public function findBy(int $id);
}

<?php

namespace Exdeliver\Causeway\Domain\Contracts\Repository;

/**
 * Interface AbstractRepositoryInterface.
 */
interface AbstractRepositoryInterface
{
    /**
     * @return int
     */
    public function findBy(int $id);
}

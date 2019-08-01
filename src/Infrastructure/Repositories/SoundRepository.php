<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Sound\Sound;

/**
 * Class SoundRepository.
 */
class SoundRepository extends AbstractRepository
{
    /**
     * PageRepository constructor.
     *
     * @param Sound $model
     */
    public function __construct(Sound $model)
    {
        parent::__construct($model);
    }
}

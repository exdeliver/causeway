<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\PhotoAlbum\Photo;

/**
 * Class PhotoRepository.
 */
class PhotoRepository extends AbstractRepository
{
    /**
     * GroupRepository constructor.
     *
     * @param Photo $model
     */
    public function __construct(Photo $model)
    {
        parent::__construct($model);
    }
}

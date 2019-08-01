<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\PhotoAlbum\PhotoAlbum;

/**
 * Class PhotoAlbumRepository.
 */
class PhotoAlbumRepository extends AbstractRepository
{
    /**
     * GroupRepository constructor.
     *
     * @param PhotoAlbum $model
     */
    public function __construct(PhotoAlbum $model)
    {
        parent::__construct($model);
    }
}

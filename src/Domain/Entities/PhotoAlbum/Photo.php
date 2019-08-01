<?php

namespace Exdeliver\Causeway\Domain\Entities\PhotoAlbum;

use Exception;
use Exdeliver\Causeway\Domain\Common\Entity;
use Exdeliver\Causeway\Domain\Services\UploadService;
use Rennokki\Befriended\Contracts\Likeable;
use Rennokki\Befriended\Traits\CanBeLiked;

/**
 * Class Photo.
 */
class Photo extends Entity implements Likeable
{
    use CanBeLiked;

    /**
     * @var array
     */
    protected $fillable = ['name', 'album_id', 'description', 'uuid', 'file_name', 'file'];

    /**
     * @param null $size
     *
     * @return string
     *
     * @throws Exception
     */
    public function getPhoto($size = null)
    {
        $dimensions = (new UploadService())->imageSizes;

        if (isset($size) && !in_array((string) $size, $dimensions, true)) {
            $supportedDimensions = implode(', ', $dimensions);
            throw new Exception('This dimension '.$size.' pixels is not supported. Supported dimensions are: '.$supportedDimensions.' pixels in width.');
        }

        return '/storage/uploads/photos/'.($size.'/' ?? null).$this->file;
    }
}

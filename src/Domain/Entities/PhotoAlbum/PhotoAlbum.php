<?php

namespace Exdeliver\Causeway\Domain\Entities\PhotoAlbum;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Exdeliver\Causeway\Domain\Common\EntityFilesTrait;

/**
 * Class PhotoAlbum
 * @package Domain\Entities\PhotoAlbum
 */
class PhotoAlbum extends AggregateRoot
{
    use EntityFilesTrait;

    /**
     * @var array
     */
    protected $with = ['allChildren'];

    /**
     * @var array
     */
    protected $fillable = ['name', 'label', 'file', 'description', 'uuid', 'parent_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function albums()
    {
        return $this->hasMany($this, 'parent_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany(new Photo(), 'album_id', 'id');
    }
}
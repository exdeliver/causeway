<?php

namespace Exdeliver\Causeway\Domain\Entities\PhotoAlbum;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Exdeliver\Causeway\Domain\Common\EntityFilesTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class PhotoAlbum.
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
     * @return HasMany
     */
    public function albums()
    {
        return $this->hasMany($this, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function photos()
    {
        return $this->hasMany(new Photo(), 'album_id', 'id');
    }
}

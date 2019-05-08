<?php

namespace Exdeliver\Causeway\Domain\Common;

use Illuminate\Support\Facades\Storage;

/**
 * Trait EntityFilesTrait
 * @package Domain\Common
 */
trait EntityFilesTrait
{
    /**
     * @return string
     */
    public function getCoverAttribute()
    {
        $file = Storage::url('uploads/photos/'.$this->file);
        return $file;
    }

    /**
     * @return mixed
     */
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    /**
     * @return mixed
     */
    public function children()
    {
        return $this->hasMany($this, 'id', 'parent_id');
    }
}

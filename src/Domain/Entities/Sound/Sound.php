<?php

namespace Exdeliver\Causeway\Domain\Entities\Sound;

use Exdeliver\Causeway\Domain\Common\Entity;
use Rennokki\Befriended\Contracts\Likeable;
use Rennokki\Befriended\Traits\CanBeLiked;

/**
 * Class Sound.
 */
class Sound extends Entity implements Likeable
{
    use CanBeLiked;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Set the label value.
     *
     * @param $value
     */
    public function setNameAttribute($value): void
    {
        if (isset($value)) {
            if ($value !== $this->name) {
                // Set slug
                $this->attributes['name'] = $this->generateIteratedName('name', $value);
            }
        } else {
            // Otherwise empty the slug
            $this->attributes['name'] = null;
        }
    }

    /**
     * @return string|null
     */
    public function getWaveformAttribute()
    {
        if (isset($this->filename)) {
            $waveform = basename(str_replace('.mp3', '.png', $this->filename));
            $path = '/storage/uploads/sounds/';

            return asset($path.$waveform);
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getPublicFilenameAttribute()
    {
        if (isset($this->attributes['filename'])) {
            return '/storage/'.str_replace('public', '', $this->attributes['filename']);
        }

        return null;
    }
}

<?php

namespace Exdeliver\Causeway\Domain\Entities\Page;

use Astrotomic\Translatable\Translatable;
use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Rennokki\Befriended\Contracts\Likeable;
use Rennokki\Befriended\Traits\CanBeLiked;

/**
 * Class Page.
 */
class Page extends AggregateRoot implements Likeable
{
    use Translatable;

    use CanBeLiked;

    /**
     * @var array
     */
    public $translatedAttributes = ['name', 'slug', 'subtitle', 'content', 'meta_title', 'meta_description', 'tags'];

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var string
     */
    protected $table = 'pages';

    /**
     * @param $value
     */
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = str_replace(['}}', '{{'], ['\}\}', '\{\{'], $value);
    }
}

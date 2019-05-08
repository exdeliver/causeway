<?php

namespace Exdeliver\Causeway\Domain\Entities\Page;

use Exdeliver\Causeway\Domain\Common\SlugTrait;
use Illuminate\Database\Eloquent\Model;
use VanOns\Laraberg\Models\Gutenbergable;

/**
 * Class PageTranslation
 * @package Domain\Entities\Page
 */
class PageTranslation extends Model
{
    use CustomGutenbergTrait;
    use SlugTrait;

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $fillable = ['page_id', 'meta_title', 'meta_description', 'tags', 'name', 'slug', 'content', 'locale', 'subtitle'];

    /**
     * Set the label value.
     *
     * @param $value
     */
    public function setSlugAttribute($value): void
    {
        if (isset($value)) {
            if ($value !== $this->slug) {
                // Set slug
                $this->attributes['slug'] = $this->generateIteratedName('slug', $value);
            }
        } else {
            // Otherwise empty the slug
            $this->attributes['slug'] = null;
        }
    }
}

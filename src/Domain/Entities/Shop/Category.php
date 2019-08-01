<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Exdeliver\Causeway\Domain\Common\ChildrenTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Category.
 */
class Category extends AggregateRoot implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use ChildrenTrait;

    /**
     * @var string
     */
    protected $table = 'shop_categories';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return array
     */
    public static function getSelectListHierarchy()
    {
        $collection = self::getParents()->with(['children'])->orderBy('sequence', 'asc')->get();

        $temp_array = [];

        foreach ($collection as $objectModel) {
            $objectModel->subs = orderedArray($objectModel->children, $objectModel['id']);
            $temp_array[] = $objectModel->toArray();
        }

        return $temp_array;
    }

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

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(new CategoryProduct());
    }
}

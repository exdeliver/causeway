<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\ProductAttributes;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Attribute.
 */
class Attribute extends AggregateRoot
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'shop_product_attributes';

    /**
     * @return HasMany
     */
    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}

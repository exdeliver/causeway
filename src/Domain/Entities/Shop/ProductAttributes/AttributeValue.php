<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\ProductAttributes;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;

/**
 * Class AttributeValue
 * @package Exdeliver\Causeway\Domain\Entities\Shop
 */
class AttributeValue extends AggregateRoot
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'shop_product_attribute_values';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(Variant::class);
    }
}
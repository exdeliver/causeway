<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\ProductAttributes;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class AttributeValue.
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
     * @return BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(Variant::class);
    }
}

<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\ProductAttributes;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;

/**
 * Class Attribute
 * @package Exdeliver\Causeway\Domain\Entities\Shop
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany(VariantValue::class);
    }
}
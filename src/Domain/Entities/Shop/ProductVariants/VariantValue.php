<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\ProductVariants;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;

/**
 * Class VariantValue
 * @package Exdeliver\Causeway\Domain\Entities\Shop
 */
class VariantValue extends AggregateRoot
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'shop_product_variant_values';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\ProductVariants;

use Exdeliver\Causeway\Domain\Entities\Shop\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class VariantProduct
 * @package Domain\Entities\Shop
 */
class VariantProduct extends Pivot
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'shop_product_variant_value_product';

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function value()
    {
        return $this->belongsTo(VariantValue::class, 'variant_value_id', 'id');
    }
}

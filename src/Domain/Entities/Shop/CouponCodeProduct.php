<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CouponCodeProduct.
 */
class CouponCodeProduct extends Pivot
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'shop_coupon_code_product';

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(new Product());
    }

    /**
     * @return BelongsTo
     */
    public function couponCode()
    {
        return $this->belongsTo(new CouponCode(), 'coupon_code_id', 'id');
    }
}

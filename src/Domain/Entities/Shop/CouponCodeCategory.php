<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CouponCodeCategory.
 */
class CouponCodeCategory extends Pivot
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'shop_coupon_code_category';

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(new Category());
    }

    /**
     * @return BelongsTo
     */
    public function couponCode()
    {
        return $this->belongsTo(new CouponCode(), 'coupon_code_id', 'id');
    }
}

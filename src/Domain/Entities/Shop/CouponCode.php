<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop;

use Exdeliver\Causeway\Domain\Common\Entity;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Product.
 */
class CouponCode extends Entity
{
    public const FIXED_PRICE_DISCOUNT = 'fixed';
    public const PERCENTAGE_DISCOUNT = 'percentage';

    /**
     * @var string
     */
    protected $table = 'shop_coupon_codes';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return array
     */
    public static function getDiscountTypes()
    {
        return [
            self::FIXED_PRICE_DISCOUNT => __('Fixed price discount'),
            self::PERCENTAGE_DISCOUNT => __('Percent of product'),
        ];
    }

    /**
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'shop_coupon_code_category', 'coupon_code_id', 'category_id');
    }

    /**
     * @return BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'shop_coupon_code_product', 'coupon_code_id', 'product_id');
    }

    /**
     * @param $value
     *
     * @return float|int
     */
    public function setDiscountAmountAttribute($value)
    {
        if (self::FIXED_PRICE_DISCOUNT === $this->attributes['discount_type']) {
            return $this->attributes['discount_amount'] = ($value * 100);
        }

        return $this->attributes['discount_amount'] = $value;
    }
}

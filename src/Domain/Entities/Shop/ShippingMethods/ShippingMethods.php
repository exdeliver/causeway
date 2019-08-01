<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\ShippingMethods;

use CWCart;
use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Exdeliver\Causeway\Domain\Common\SlugTrait;
use Exdeliver\Causeway\Domain\Entities\Shop\PricingTrait;

/**
 * Class ShippingMethods.
 */
class ShippingMethods extends AggregateRoot
{
    use SlugTrait;
    use PricingTrait;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'shop_shipping_methods';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $appends = ['vat_price_formatted', 'is_free_shipping', 'total_free_shipping_threshold_formatted'];

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
                $this->attributes['name'] = $this->generateIteratedName('name', $value);
            }
        } else {
            // Otherwise empty the slug
            $this->attributes['name'] = null;
        }
    }

    /**
     * @param int $subtotal
     *
     * @return bool
     */
    public function getIsFreeShippingAttribute(): bool
    {
        if ((null !== $this->total_free_shipping_threshold && $this->total_free_shipping_threshold > 0) && CWCart::subtotal() > $this->total_free_shipping_threshold) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getTotalFreeShippingThresholdFormattedAttribute()
    {
        return null !== $this->total_free_shipping_threshold ? money($this->total_free_shipping_threshold, 'eur')->format() : null;
    }
}

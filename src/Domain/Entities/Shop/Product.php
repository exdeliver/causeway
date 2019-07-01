<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop;

use Exdeliver\Causeway\Domain\Common\Entity;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Product
 * @package Exdeliver\Causeway\Domain\Entities\Shop
 */
class Product extends Entity implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    /**
     * Product types that Causeway Supports
     */
    public const REGULAR_PRODUCT = ['type' => 'regular',
        'description' => 'Regular shippable product.'];
    public const COMPLEX_PRODUCT = ['type' => 'complex',
        'description' => 'Configurable complex product.'];
    public const BOOKING_PRODUCT = ['type' => 'booking',
        'description' => 'Product that is bookable for a period of time.'];
    public const SERVICE_PRODUCT = ['type' => 'service',
        'description' => 'Product that is a service.'];
    public const DOWNLOAD_PRODUCT = ['type' => 'download',
        'description' => 'Product that needs to be downloaded.'];
    public const RENTAL_PRODUCT = ['type' => 'rental',
        'description' => 'Product that is being rented for a period of time.'];

    /**
     * @var string
     */
    protected $table = 'shop_products';

    /**
     * @var array
     */
    protected $appends = ['vat_price', 'original_vat_price'];

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'shop_category_product', 'product_id', 'category_id');
    }

    /**
     * VAT amount to pay.
     *
     * @return float|int
     */
    public function getVatToPayAttribute()
    {
        $grossPrice = ($this->special_price > 0 && $this->special_price < $this->gross_price) ? $this->special_price : $this->gross_price;

        return ($grossPrice / 100) * $this->vat;
    }

    /**
     * @param $value
     * @return float|int
     */
    public function setGrossPriceAttribute($value)
    {
        return $this->attributes['gross_price'] = ($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function setSpecialPriceAttribute($value)
    {
        return $this->attributes['special_price'] = ($value * 100);
    }

    /**
     * Get original vat price.
     *
     * @return int
     */
    public function getOriginalVatPriceAttribute()
    {
        $vatToPay = ($this->gross_price / 100) * $this->vat;
        return $this->gross_price + $vatToPay;
    }

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
                $this->attributes['slug'] = $this->generateIteratedName('slug', $value);
            }
        } else {
            // Otherwise empty the slug
            $this->attributes['slug'] = null;
        }
    }

    /**
     * Get calculated vat price.
     *
     * @return int
     */
    public function getVatPriceAttribute()
    {
        // Get gross price directly from product depending on special price.
        $grossPrice = ($this->special_price > 0 && $this->special_price < $this->gross_price) ? $this->special_price : $this->gross_price;
        $vatToPay = ($grossPrice / 100) * $this->vat;

        // Room for other calculations.
        return $grossPrice + $vatToPay;
    }

    /**
     * Get fully qualified name slug.
     * @return string
     */
    public function getFqnSlugAttribute()
    {
        return '/shop/product/' . $this->slug;
    }

    /**
     * Get stock.
     *
     * @return integer
     */
    public function getStockAttribute()
    {
        return $this->quantity;
    }
}
<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop;

use Exdeliver\Causeway\Domain\Common\Entity;
use Exdeliver\Causeway\Domain\Entities\Shop\ProductAttributes\Attribute;
use Exdeliver\Causeway\Domain\Entities\Shop\ProductAttributes\AttributeValue;
use Exdeliver\Causeway\Domain\Entities\Shop\ProductBookingDates\BookingDate;
use Exdeliver\Causeway\Domain\Entities\Shop\ProductVariants\Variant;
use Exdeliver\Causeway\Domain\Entities\Shop\ProductVariants\VariantValue;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Product.
 */
class Product extends Entity implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use PricingTrait;

    /**
     * Product types that Causeway Supports.
     */
    public const REGULAR_PRODUCT = ['type' => 'regular',
        'description' => 'Regular shippable product.', ];
    public const COMPLEX_PRODUCT = ['type' => 'complex',
        'description' => 'Configurable complex product.', ];
    public const VARIANT_PRODUCT = ['type' => 'variant',
        'description' => 'Variant product belongs to a complex product.', ];
    public const BOOKING_PRODUCT = ['type' => 'booking',
        'description' => 'Product that is bookable for a period of time.', ];
    public const SERVICE_PRODUCT = ['type' => 'service',
        'description' => 'Product that is a service.', ];
    public const DOWNLOAD_PRODUCT = ['type' => 'download',
        'description' => 'Product that needs to be downloaded.', ];
    public const RENTAL_PRODUCT = ['type' => 'rental',
        'description' => 'Product that is being rented for a period of time.', ];

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
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'shop_category_product', 'product_id', 'category_id');
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
     * Get fully qualified name slug.
     *
     * @return string
     */
    public function getFqnSlugAttribute()
    {
        return '/shop/product/'.$this->slug;
    }

    /**
     * Get stock.
     *
     * @return int
     */
    public function getStockAttribute()
    {
        return $this->quantity;
    }

    /**
     * @return HasMany
     */
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    /**
     * @return HasMany
     */
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    /**
     * @return BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(AttributeValue::class);
    }

    /**
     * @return BelongsToMany
     */
    public function variant()
    {
        return $this->belongsToMany(VariantValue::class, 'shop_product_variant_value_product', 'product_id', 'value_id');
    }

    /**
     * @return HasMany
     */
    public function bookingDates()
    {
        return $this->hasMany(BookingDate::class);
    }

    /**
     * Get collection of variants.
     *
     * @return mixed
     */
    public function getVariantsCollection()
    {
        $variants = $this->variants->map(function ($variant) {
            $variantType = ['id' => $variant['id'],
                'name' => $variant->name,
                'sequence' => $variant->sequence,
                'values' => $variant->values->map(function ($value) {
                    return [
                        'id' => $value['id'],
                        'name' => $value->variant_value,
                        'sequence' => $value->sequence,
                    ];
                }),
            ];

            return $variantType;
        });

        return $variants;
    }

    /**
     * Get collection of variants.
     *
     * @return mixed
     */
    public function getBookingsCollection()
    {
        $bookings = $this->bookingDates()->orderBy('date_from')->get()->map(function ($booking) {
            $bookingType = [
                'id' => $booking['id'],
                'type' => $booking['type'],
                'date_from' => $booking->date_from->format('Y-m-d'),
                'date_to' => $booking->date_to->format('Y-m-d'),
                'gross_price' => $booking->gross_price / 100,
                'special_price' => $booking->special_price / 100,
                'quantity' => $booking->quantity,
            ];

            return $bookingType;
        });

        return $bookings;
    }

    /**
     * Get product variants.
     */
    public function getVariants()
    {
        return self::where('parent_product_id', $this['id'])->where('type', self::VARIANT_PRODUCT['type'])->get();
    }

    /**
     * @return array
     */
    public static function getProductTypes()
    {
        return [
            self::REGULAR_PRODUCT,
            self::COMPLEX_PRODUCT,
            self::BOOKING_PRODUCT,
            self::SERVICE_PRODUCT,
            self::DOWNLOAD_PRODUCT,
            self::RENTAL_PRODUCT,
        ];
    }
}

<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\ProductBookingDates;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Exdeliver\Causeway\Domain\Entities\Shop\PricingTrait;
use Exdeliver\Causeway\Domain\Entities\Shop\Product;

/**
 * Class BookingDate
 * @package Exdeliver\Causeway\Domain\Entities\Shop
 */
class BookingDate extends AggregateRoot
{
    use PricingTrait;

    /**
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * @var string
     */
    protected $table = 'shop_product_booking_dates';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $dates = [
        'date_from',
        'date_to',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
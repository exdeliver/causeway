<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\ProductBookingDates;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Exdeliver\Causeway\Domain\Entities\Shop\Product;

/**
 * Class BookingDate
 * @package Exdeliver\Causeway\Domain\Entities\Shop
 */
class BookingDate extends AggregateRoot
{
    /**
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * @var string
     */
    protected $table = 'shop_product_booking_dates';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
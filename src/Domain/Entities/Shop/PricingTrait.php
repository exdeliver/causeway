<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop;

/**
 * Trait PricingTrait
 * @package Exdeliver\Causeway\Domain\Entities\Shop
 */
trait PricingTrait
{
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
     * Get calculated vat price.
     *
     * @return int
     */
    public function getVatPriceFormattedAttribute()
    {
        // Get gross price directly from product depending on special price.
        $grossPrice = ($this->special_price > 0 && $this->special_price < $this->gross_price) ? $this->special_price : $this->gross_price;
        $vatToPay = ($grossPrice / 100) * $this->vat;

        // Room for other calculations.
        return money($grossPrice + $vatToPay,'eur')->format();
    }
}
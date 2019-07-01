<?php

namespace Exdeliver\Causeway\Domain\Services;

use Akaunting\Money\Money;
use Exdeliver\Causeway\Domain\Entities\Shop\CouponCode;
use Illuminate\Support\Collection;

/**
 * Class ShopCalculationService
 */
class ShopCalculationService
{
    /**
     * @var
     */
    public $items;

    /**
     * @param $collection
     */
    public function setCollection($collection)
    {
        $this->items = $collection;
    }

    /**
     * @return integer
     */
    public function items_gross_total()
    {
        $collection = $this->calculations();

        return $collection->sum('total_gross_price');
    }

    /**
     * @return Collection
     */
    public function calculations()
    {
        $collection = $this->items();

        $collection = $collection->map(function ($item) {

            $grossPrice = (isset($item->special_price) && $item->special_price > 0 && $item->special_price < $item->gross_price) ? $item->special_price : $item->gross_price;

            // Original vat price
            $item->original_vat_price = $item->gross_price * ($item->vat / 100 + 1);
            $item->original_vat_price_format = money($item->original_vat_price, 'EUR')->format();

            // Gross price calculated by discount
            $item->total_gross_price = $grossPrice * $item->quantity;
            $item->total_gross_price_format = money($item->total_gross_price, 'EUR')->format();

            // Vat price calculated by discount
            $item->vat_price = $item->total_gross_price * ($item->vat / 100 + 1);
            $item->vat_price_format = money($item->vat_price, 'EUR')->format();
            $item->vat_price_total_format = money($item->vat_price, 'EUR')->format();

            $item->total_vat_price = $item->vat_price * $item->quantity;
            $item->total_vat_price_format = money($item->total_vat_price, 'EUR')->format();

            $item->vat_total = ($item->total_gross_price / 100) * $item->vat;
            $item->vat_total_format = money($item->vat_total, 'EUR')->format();

            return $item;
        });

        return $collection;
    }

    /**
     * returns items
     *
     * @return Collection
     */
    public function items()
    {
        $collection = $this->getCollection();

        $collection = $collection->where('type', '!=', 'discount')->where('quantity', '>', 0)->map(function ($item) {
            $item = (object)$item;
            return $item;
        });

        return $collection;
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        $content = $this->items;

        return $content;
    }

    /**
     * @return integer
     */
    public function items_vat_total()
    {
        $collection = $this->calculations();

        return $collection->sum('vat_price');
    }

    /**
     * @return integer
     */
    public function quantity()
    {
        $collection = $this->items()->where('type', 'item');

        return $collection->sum('quantity');
    }

    /**
     * @return float|int
     */
    public function serviceFee()
    {
        return $this->items()->where('type', 'fee')->sum('total_vat_price');
    }

    /**
     * @return integer
     */
    public function total()
    {
        return ($this->subtotal() + $this->grossServiceFee()) + $this->discountedTotal()->sum('amount');
    }

    /**
     * @return integer
     */
    public function subtotal()
    {
        $collection = $this->calculations();

        $subtotal = $collection->where('type', 'item')->sum('total_gross_price');

        $discounts = ($this->discounts()->sum('discount_price') > 0) ? $this->discounts()->sum('discount_price') : 0;

        return $subtotal - $discounts;
    }

    /**
     * @return Collection|\Illuminate\Support\Collection
     */
    public function discounts()
    {
        $collection = $this->getCollection();

        $vatItemsTotal = $this->calculations()->sum('total_gross_price');

        $collection = $collection->where('type', '=', 'discount')->map(function ($item) use ($vatItemsTotal) {
            $item = (object)$item;

            $item->subject_total = $vatItemsTotal;
            $result = null;

            if ($item->discount_type === CouponCode::FIXED_PRICE_DISCOUNT) {
                $result = $item->discount_amount;

            } elseif ($item->discount_type === CouponCode::FIXED_PRICE_DISCOUNT || $item->discount_type === CouponCode::PERCENTAGE_DISCOUNT) {
                $result = (($vatItemsTotal / 100) * $item->discount_amount);
            }

            $item->discount_price = $result;
            $item->vat_price = $result;

            return $item;
        });

        return $collection;
    }

    /**
     * @return float|int
     */
    public function grossServiceFee()
    {
        return $this->items()->where('type', 'fee')->sum('total_gross_price');
    }

    /**
     * @return array|Collection
     */
    public function discountedTotal()
    {
        $collection = $this->items();

        $totalVatPrice = $collection->sum('total_gross_price');

        $discount = $this->discounts();

        $ratos = [];

        if (isset($discount) && count($discount) > 0) {
            $discount = $discount->sum('discount_price');
        } else {
            $discount = 0;
        }

        $total_per_vat = [];

        if (count($collection) > 0) {
            foreach ($collection as $item) {
                if (!isset($total_per_vat[$item->vat])) {
                    $total_per_vat[$item->vat] = ($discount > 0) ? $item->total_gross_price : $item->vat_total;
                } else {
                    $total_per_vat[$item->vat] += ($discount > 0) ? $item->total_gross_price : $item->vat_total;
                }
            }
        }

        if (isset($total_per_vat)) {
            foreach ($total_per_vat as $vat => $amount) {
                if (isset($discount) && $discount > 0) {
                    $subjectDiscount = ($discount / $totalVatPrice) * $amount;
                    $vatAmount = ($amount - $subjectDiscount) * ($vat / 100);
                } else {
                    $vatAmount = $amount;
                }
                if (isset($vatAmount) && $vatAmount > 0) {
                    $ratos[] = [
                        'vat_total' => $amount,
                        'vat' => $vat,
                        'formatted_vat' => __('VAT') . ' ' . ($vat + 0) . '%',
                        'amount' => $vatAmount ?? 0,
                        'formatted_amount' => Money::EUR($vatAmount ?? 0)->format(),
                    ];
                }
            }
        }

        $ratos = collect($ratos);

        return $ratos;
    }

    /**
     * @return int
     */
    public function totalBeforeDiscount()
    {
        return $this->subtotal() + $this->vatTotal();
    }

    /**
     * @return integer
     */
    public function vatTotal()
    {
        return $this->discountedTotal()->sum('amount');
    }

    /**
     * @return string
     */
    public function vats()
    {
        return $this->discountedTotal();
    }
}
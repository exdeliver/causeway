<?php

namespace Exdeliver\Causeway\Domain\Entities\Cart;

/**
 * Class Item
 * @package Domain\Entities\Cart
 */
class Item
{
    public $id;
    public $product_id;
    public $name;
    public $gross_price;
    public $vat;
    public $quantity;
    public $type;
    public $attributes;

    public function __construct(array $item)
    {
        if (count($item)) {
            foreach ($item as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    public function update($params)
    {
        if (count($params) > 0) {
            foreach ($params as $param => $value) {
                $this->{$param} = $value;
            }
        }
    }

    /**
     * @return \Akaunting\Money\Money
     */
    public function getPrice()
    {
        return money($this->gross_price, 'EUR');
    }
}
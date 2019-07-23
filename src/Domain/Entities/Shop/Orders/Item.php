<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Orders;

use Exdeliver\Causeway\Domain\Common\Entity;
use Exdeliver\Causeway\Domain\Entities\Shop\Product;

/**
 * Class Item
 * @package Domain\Entities\Orders
 */
class Item extends Entity
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var string
     */
    protected $table = 'order_lines';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ticketType()
    {
        return $this->hasOne(new Product(), 'id', 'product_id');
    }
}

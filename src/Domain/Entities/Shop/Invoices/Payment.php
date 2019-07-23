<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Invoices;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Exdeliver\Causeway\Domain\Entities\Shop\Orders\Order;

/**
 * Class Payment
 * @package Domain\Entities\Invoices
 */
class Payment extends AggregateRoot
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(new Order(), 'order_id', 'id');
    }
}

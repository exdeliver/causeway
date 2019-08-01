<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Invoices;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Exdeliver\Causeway\Domain\Entities\Shop\Orders\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Payment.
 */
class Payment extends AggregateRoot
{
    /**
     * @return BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(new Order(), 'order_id', 'id');
    }
}

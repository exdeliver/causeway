<?php

namespace Exdeliver\Causeway\Domain\Contracts\Services;

use Exdeliver\Causeway\Domain\Entities\Shop\Customers\Contact;
use Exdeliver\Causeway\Domain\Entities\Shop\Orders\Order;

/**
 * Interface Shipping
 * @package Domain\Contracts\Services
 */
interface Shipping
{
    public function createConsignment(Order $order, Contact $sendTo);
}
<?php

namespace Exdeliver\Causeway\Domain\Contracts\Services;

use Exdeliver\Causeway\Domain\Entities\Shop\Orders\Order;

/**
 * Interface Payment
 * @package Domain\Contracts\Services
 */
interface Payment
{
    public function generate(Order $order);

    public function validate(Order $order): bool;
}
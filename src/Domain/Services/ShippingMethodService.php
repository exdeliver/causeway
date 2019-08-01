<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exception;
use Exdeliver\Causeway\Domain\Contracts\Services\Shipping;
use Exdeliver\Causeway\Domain\Entities\Shop\Customers\Contact;
use Exdeliver\Causeway\Domain\Entities\Shop\Orders\Order;
use Exdeliver\Causeway\Infrastructure\Repositories\ShippingMethodRepository;

/**
 * Class ShippingMethodService.
 */
final class ShippingMethodService extends AbstractApiService implements Shipping
{
    /**
     * SoundService constructor.
     *
     * @param ShippingMethodRepository $shippingMethodRepository
     */
    public function __construct(ShippingMethodRepository $shippingMethodRepository)
    {
        $this->repository = $shippingMethodRepository;
    }

    /**
     * @param Order   $order
     * @param Contact $sendTo
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function createConsignment(Order $order, Contact $sendTo)
    {
        $service = $this->getProvider($order->shipping_service);

        return $service->createConsignment($order, $sendTo);
    }
}

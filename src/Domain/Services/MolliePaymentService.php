<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exception;
use Exdeliver\Causeway\Domain\Contracts\Services\Payment;
use Exdeliver\Causeway\Domain\Entities\Shop\Orders\Order;
use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\MollieApiClient;

/**
 * Class MollieService.
 */
class MolliePaymentService extends AbstractService implements Payment
{
    /**
     * @var MollieApiClient
     */
    protected $mollie;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $mollieKey;

    /**
     * MollieService constructor.
     *
     * @param MollieApiClient $mollieApiClient
     *
     * @throws ApiException
     */
    public function __construct(MollieApiClient $mollieApiClient)
    {
        if ('production' === env('APP_ENV')) {
            $this->mollie_key = env('MOLLIE_LIVE_API_KEY', null);
        } else {
            $this->mollie_key = env('MOLLIE_TEST_API_KEY', null);
        }

        if (isset($this->mollie_key)) {
            $this->setKey($this->mollie_key);
        }

        $mollieApiClient = $mollieApiClient->setApiKey($this->getKey());

        $this->mollie = $mollieApiClient;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key)
    {
        $this->key = $key;
    }

    /**
     * @param Order $order
     *
     * @return \Mollie\Api\Resources\Payment
     *
     * @throws Exception
     */
    public function generate(Order $order)
    {
        try {
            $mollie = $this->mollie;

            $payment = $mollie->payments->create([
                'method' => $order->selected_method,
                'amount' => ['value' => $order->formatted_mollie_payment_total,
                    'currency' => 'EUR', ],
                'description' => __('Order payment for order: '.$order->uuid.' to '.env('APP_NAME')),
                'redirectUrl' => route('shop.order.status', ['uuid' => $order->uuid]),
                'webhookUrl' => route('api.mollie-payment'),
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ]);
        } catch (Exception $e) {
            logger()->error('Mollie attempt create payment error.', ['exception' => $e]);
            throw new Exception($e->getMessage());
        }

        return $payment;
    }

    /**
     * @param Order $order
     *
     * @return bool
     *
     * @throws ApiException
     */
    public function validate(Order $order): bool
    {
        $mollie = $this->mollie;

        $mollie->setApiKey($this->getKey());

        $payment = $mollie->payments->get($order->payment_id);

        return $payment->isPaid();
    }

    /**
     * Get Mollie Client.
     */
    public function getClient()
    {
        return $this->mollie;
    }
}

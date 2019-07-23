<?php

namespace Exdeliver\Causeway\Domain\Services;

use Carbon\Carbon;
use Exdeliver\Causeway\Domain\Contracts\Services\Payment as PaymentInterface;
use Exdeliver\Causeway\Domain\Entities\Shop\Invoices\Invoice;
use Exdeliver\Causeway\Domain\Entities\Shop\Invoices\Payment;
use Exdeliver\Causeway\Domain\Entities\Shop\Orders\Order;

/**
 * Class PaymentService
 *
 * @package Domain\Services
 */
final class PaymentService extends AbstractApiService implements PaymentInterface
{
    /**
     * @param Order $order
     * @return Order
     * @throws \Exception
     */
    public function generate(Order $order)
    {
        $service = $this->getProvider($order->payment_service);

        $payment = $service->generate($order);

        $order->payment_id = $payment->id;

        unset($order->selected_method);

        $order->save();

        $order->payment_link = $payment->_links->checkout->href;

        return $order;
    }

    /**
     * @param Order $order
     * @return bool
     * @throws \Exception
     */
    public function validate(Order $order): bool
    {
        $service = $this->getProvider($order);

        $paid = $service->validate($order);

        if ($paid) {
            $paidAtDateTime = Carbon::now();

            $order->paid_at = $paidAtDateTime;
            $order->status = Order::STATUS_AWAITING_FULFILLMENT;
            $order->save();

            if (!isset($order->invoice)) {
                $invoice = new Invoice();
                $invoice->paid_at = $paidAtDateTime;
                $invoice->order_id = $order->id;
                $invoice->save();

                $payment = new Payment();
                $payment->order_id = $order->id;
                $payment->service = $order->payment_method;
                $payment->save();
            }

            return true;
        } else {
            $order->paid_at = null;
            $order->status = Order::STATUS_AWAITING_PAYMENT;
            $order->save();

            if (isset($order->invoice)) {
                $invoice = $order->invoice;
                $invoice->delete();
            }
        }

        return false;
    }
}
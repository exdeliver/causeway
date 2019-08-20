<?php

namespace Exdeliver\Causeway\Notifications;

use Exdeliver\Causeway\Domain\Entities\Shop\Orders\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class OrderNotificationMail.
 */
class OrderNotificationMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var Order
     */
    protected $order;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->markdown('site::shop.mail.order', [
                'customer' => $this->order->customer->primaryContact(),
                'order' => $this->order,
            ])
            ->subject(__('Thank you for your order - '.config('app.name')));
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }
}

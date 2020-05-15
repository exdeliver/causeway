<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Customers;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Exdeliver\Causeway\Domain\Entities\Shop\Orders\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

/**
 * Class Customer.
 */
class Customer extends AggregateRoot
{
    use Notifiable;

    /**
     * @var string
     */
    protected $table = 'customers';

    /**
     * @var array
     */
    protected $guard = [];

    /**
     * @return Model|HasMany|object|null
     */
    public function shippingContact()
    {
        return $this->contacts()->where('type', '=', 'shipping')->first();
    }

    /**
     * @return HasMany
     */
    public function contacts()
    {
        return $this->hasMany(new Contact());
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param Notification $notification
     *
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->primaryContact()->email;
    }

    /**
     * @return Model|HasMany|object|null
     */
    public function primaryContact()
    {
        return $this->contacts()->where('primary', '=', Contact::PRIMARY_CONTACT)->first();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

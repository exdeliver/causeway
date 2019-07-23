<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Customers;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Illuminate\Notifications\Notifiable;

/**
 * Class Customer
 * @package Domain\Entities\Invoices
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
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function shippingContact()
    {
        return $this->contacts()->where('type', '=', 'shipping')->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(new Contact());
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param \Illuminate\Notifications\Notification $notification
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->primaryContact()->email;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function primaryContact()
    {
        return $this->contacts()->where('primary', '=', Contact::PRIMARY_CONTACT)->first();
    }
}

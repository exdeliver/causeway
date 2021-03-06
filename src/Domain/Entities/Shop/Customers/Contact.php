<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Customers;

use Exdeliver\Causeway\Domain\Common\Entity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Contact.
 */
class Contact extends Entity implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public const PRIMARY_CONTACT = 1;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(new Customer(), 'customer_id', 'id');
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        $name = '';

        $name .= $this->first_name ?? '';

        $space = $this->first_name ? ' ' : '';

        $name .= $this->last_name ? $space.$this->last_name : '';

        return $name;
    }
}

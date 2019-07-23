<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\Orders;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Exdeliver\Causeway\Domain\Entities\Shop\Customers\Customer;
use Exdeliver\Causeway\Domain\Entities\Shop\Invoices\Invoice;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Order
 * @package Domain\Entities\Orders
 */
class Order extends AggregateRoot implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    /**
     * Order statuses
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_AWAITING_PAYMENT = 'awaiting_payment';
    public const STATUS_AWAITING_SHIPMENT = 'awaiting_shipment';
    public const STATUS_AWAITING_PICKUP = 'awaiting_pickup';
    public const STATUS_PARTIALLY_SHIPPED = 'partially_shipped';
    public const STATUS_AWAITING_FULFILLMENT = 'awaiting_fulfillment';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_DECLINED = 'declined';
    public const STATUS_REFUNDED = 'refunded';
    public const STATUS_DISPUTED = 'disputed';
    public const STATUS_PARTIALLY_REFUNDED = 'partially_refunded';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return array
     */
    public static function getOrderStatuses()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_AWAITING_PAYMENT,
            self::STATUS_AWAITING_SHIPMENT,
            self::STATUS_AWAITING_PICKUP,
            self::STATUS_PARTIALLY_SHIPPED,
            self::STATUS_AWAITING_FULFILLMENT,
            self::STATUS_COMPLETED,
            self::STATUS_SHIPPED,
            self::STATUS_CANCELED,
            self::STATUS_DECLINED,
            self::STATUS_REFUNDED,
            self::STATUS_DISPUTED,
            self::STATUS_PARTIALLY_REFUNDED,
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function downloadableProducts()
    {
        return $this->hasMany(new Item(), 'order_id', 'id')->where('type', '!=', 'fee');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice()
    {
        return $this->hasOne(new Invoice());
    }

    /**
     * @return string
     */
    public function getFormattedMolliePaymentTotalAttribute()
    {
        return number_format($this->mollie_payment_total / 100, 2);
    }

    /**
     * @return int
     */
    public function getGrossFeeTotalAttribute()
    {
        $products = $this->items->map(function ($product) {
            $type['gross_fee'] = $product->ticketType->fee * $product->quantity;
            return $type;
        });

        $productFee = $products->sum('gross_fee'); // excl vat

        $feePerOrder = isset($this->event->fee) ?? 0;

        return $productFee + $feePerOrder;
    }

    /**
     * @return int
     */
    public function getGrossItemTotalAttribute()
    {
        return $this->items->sum('gross_price');
    }

    public function getQuantityAttribute()
    {
        return $this->items()->where('type', 'item')->sum('quantity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(new Item(), 'order_id', 'id');
    }

    /**
     * @return int
     */
    public function getFeeTotalAttribute()
    {
        $products = $this->items->map(function ($product) {
            $type['fee'] = ($product->ticketType->fee * ($product->ticketType->fee_vat / 100) + 1) * $product->quantity;
            return $type;
        });

        $productFee = $products->sum('fee'); // excl vat

        $feePerOrder = ($this->event->fee * ($this->event->fee_vat / 100) + 1);

        return $productFee + $feePerOrder;
    }

    /**
     * @return bool
     */
    public function getIsPaidAttribute()
    {
        return isset($this->paid_at) && !empty($this->paid_at);
    }

    /**
     * @return string
     */
    public function getPaymentServiceAttribute()
    {
        return ucfirst(camel_case($this->payment_method . '_service'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(new Customer());
    }

    /**
     * @param $query
     * @param $request
     * @return mixed
     */
    public function scopeSearchBy($query, $request)
    {
        $orderByColumns = [
            'orders.created_at',
            'orders.id',
            'fullname',
            'contacts.email',
            'orders.payment_id',
            'orders.paid_at',
            'gross_price_sum',
        ];

        $query = $query->calculatedOrders();

        if (isset($request->search)) {
            $search = $request->search;

            $query->whereHas('customer.contacts', function ($query) use ($search) {
                $query->where('contacts.first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('contacts.last_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('contacts.email', 'LIKE', '%' . $search . '%');
            })
                ->orWhere('payment_id', $search);
        }

        if (isset($request->sortBy) && in_array($request->sortBy, $orderByColumns, true)) {
            $sortByColumn = $request->sortBy;
        } else {
            $sortByColumn = 'orders.created_at';
        }

        $query->orderBy($sortByColumn, $request->direction === 'asc' ? 'asc' : 'desc');

        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeCalculatedOrders($query)
    {
        $query->join('customers', 'orders.customer_id', 'customers.id')
            ->join('contacts', 'customers.id', 'contacts.customer_id')
            ->join('events', 'events.id', 'orders.event_id')
            ->select([
                DB::raw("CONCAT(contacts.first_name,' ',contacts.last_name) AS fullname"),
                'orders.created_at',
                'orders.payment_id',
                'orders.id',
                'orders.payment_id',
                'orders.paid_at',
                'orders.uuid',
                'orders.mollie_payment_total',
                'events.slug',
                'contacts.*',
            ])
            ->withCount([
                'items AS gross_price_sum' => function ($query) {
                    $query->where('type', 'item')->select(
                        DB::raw("SUM(gross_price*quantity) as grosspricesum")
                    );
                },
                'items AS vat_price_sum' => function ($query) {
                    $query->where('type', 'item')->select(
                        DB::raw("SUM((gross_price * ((vat/100)+1))*quantity) as vatpricesum")
                    );
                },
            ]);
        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeWithPaymentMethod($query)
    {
        return $query->whereIn('orders.payment_method', ['mollie']);
    }

    public function scopeHasPaid($query)
    {
        return $query->withPaymentMethod()->whereNotNull('paid_at');
    }

    /**
     * @return string
     */
    public function getStatusFormatAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->status));
    }

    /**
     * Get step for order.
     *
     * @return int
     */
    public function getProcessStepAttribute()
    {
        switch ($this->status) {
            case self::STATUS_AWAITING_FULFILLMENT:
                return 1;
                break;
            case self::STATUS_PENDING:
                return 1;
                break;
            case self::STATUS_SHIPPED:
                return 3;
                break;
            case self::STATUS_COMPLETED:
                return 4;
                break;
        }
    }
}

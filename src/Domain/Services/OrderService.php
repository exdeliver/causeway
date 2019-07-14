<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exdeliver\Cart\Domain\Services\CartService;
use Exdeliver\Cart\Domain\Services\ShopCalculationService;
use Exdeliver\Causeway\Domain\Entities\Shop\Customers\Customer;
use Exdeliver\Causeway\Domain\Entities\Shop\Orders\Item;
use Exdeliver\Causeway\Domain\Entities\Shop\Orders\Order;
use Exdeliver\Causeway\Infrastructure\Repositories\OrderRepository;
use Exdeliver\Causeway\Notifications\OrderNotificationMail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * Class OrderService
 * @package Domain\Services
 */
class OrderService extends AbstractService
{
    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * @var mixed
     */
    protected $companyInformation;

    /**
     * OrderService constructor.
     *
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->companyInformation = causewayCompanyInformation();
    }

    /**
     * @param CartService $cart
     * @param Customer $customer
     * @return mixed
     * @throws \Exception
     */
    public function saveOrderByCart(CartService $cart, Customer $customer)
    {
        $items = $cart->all();
        return $this->saveOrder($items, $customer, 'molliePayment', $cart->total());
    }

    /**
     * @param Collection $items
     * @param Customer $customer
     * @param string $paymentMethod
     * @param null $paymentTotal
     * @return Order $order
     */
    public function saveOrder(Collection $items, Customer $customer, string $paymentMethod, $paymentTotal = null): Order
    {
        $order = $this->orderRepository->create([
            'customer_id' => $customer->id,
            'uuid' => Str::uuid(),
            'payment_method' => $paymentMethod,
            'mollie_payment_total' => $paymentTotal,
            'status' => Order::STATUS_PENDING,
            'paid_at' => null,
        ]);

        $items->each(function ($item) use ($order) {
            $productArray = [
                'order_id' => $order->id,
                'name' => $item->name,
                'type' => $item->type,
            ];

            if ($item->type === 'discount') {
                $productArray['gross_price'] = '-' . $item->discount_price;
                $productArray['quantity'] = 1;
                $productArray['discount_type'] = $item->discount_type;
                $productArray['discount_amount'] = $item->discount_amount;
            } else {
                $productArray['vat'] = $item->vat;
                $productArray['quantity'] = $item->quantity;
                $productArray['product_id'] = (int)$item->product_id;
                $productArray['gross_price'] = (isset($item->special_price) && $item->special_price > 0 && $item->special_price < $item->gross_price) ? $item->special_price : $item->gross_price;
            }

            Item::create($productArray);
        });

        return $order;
    }

    /**
     * @param Order $order
     */
    public function sendPaymentConfirmationToCustomer(Order $order)
    {
        /** @var Customer $customer */
        $customer = $order->customer;

        Mail::to($customer->primaryContact()->email, $customer->primaryContact()->full_name)
            ->send(new OrderNotificationMail($order));
    }

    /**
     * @param Order $order
     */
    public function sendOrderConfirmationToCustomer(Order $order)
    {
        /** @var Customer $customer */
        $customer = $order->customer;

        Mail::to($customer->primaryContact()->email, $customer->primaryContact()->full_name)
            ->send(new OrderNotificationMail($order));
    }

    /**
     * @param Order $order
     * @return string
     */
    public function invoicePdf(Order $order)
    {
        /** @var ShopCalculationService $shopCalculationService */
        $shopCalculationService = app(ShopCalculationService::class);
        $shopCalculationService->setCollection($order->items);

        $invoiceHTML = view('causeway::shop.pdf.invoice', [
            'order' => $order,
            'subtotal' => $shopCalculationService->subtotal(),
            'vats' => $shopCalculationService->vats(),
            'total' => $shopCalculationService->total(),
            'invoiceContact' => $order->customer->primaryContact(),
            'shippingContact' => $order->customer->shippingContact(),
            'fees' => $shopCalculationService->grossServiceFee(),
            'total_before_discount' => $shopCalculationService->totalBeforeDiscount(),
            'companyInformation' => $this->companyInformation,
        ]);

        if (isset(request()->html)) {
            return $invoiceHTML;
        }

        $pdf = \PDF::setOption('margin-bottom', 0)
            ->setOption('margin-top', 0)
            ->setOption('viewport-size', '1280x1024')
            ->loadView('causeway::shop.pdf.invoice', [
                'order' => $order,
                'subtotal' => $shopCalculationService->subtotal(),
                'vats' => $shopCalculationService->vats(),
                'total' => $shopCalculationService->total(),
                'invoiceContact' => $order->customer->primaryContact(),
                'shippingContact' => $order->customer->shippingContact(),
                'fees' => $shopCalculationService->grossServiceFee(),
                'total_before_discount' => $shopCalculationService->totalBeforeDiscount(),
                'companyInformation' => $this->companyInformation,
            ]);

        $uploadPath = public_path() . '/invoices/';
        $savePath = $uploadPath . $order->uuid . '.pdf';

        // path does not exist
        if (!file_exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0775, true);
        }

        return \PDF::inline($order->uuid);
    }
}
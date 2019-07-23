<?php

namespace Exdeliver\Causeway\Controllers\Shop;

use App\Http\Controllers\Controller;
use Exception;
use Exdeliver\Cart\Domain\Services\CartService;
use Exdeliver\Cart\Domain\Services\ShopCalculationService;
use Exdeliver\Causeway\Domain\Entities\Shop\Orders\Order;
use Exdeliver\Causeway\Domain\Services\CouponCodeService;
use Exdeliver\Causeway\Domain\Services\CustomerService;
use Exdeliver\Causeway\Domain\Services\OrderService;
use Exdeliver\Causeway\Domain\Services\PaymentService;
use Exdeliver\Causeway\Requests\PostCheckoutRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class OrderController
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * @var CustomerService
     */
    protected $customerService;

    /**
     * @var PaymentService
     */
    protected $paymentService;

    /**
     * @var CouponCodeService
     */
    protected $couponCodeService;

    /**
     * OrderController constructor.
     * @param OrderService $orderService
     * @param CustomerService $customerService
     * @param PaymentService $paymentService
     * @param CouponCodeService $couponCodeService
     */
    public function __construct(OrderService $orderService, CustomerService $customerService, PaymentService $paymentService, CouponCodeService $couponCodeService)
    {
        $this->orderService = $orderService;
        $this->customerService = $customerService;
        $this->paymentService = $paymentService;
        $this->couponCodeService = $couponCodeService;
    }

    /**
     * Show order status.
     *
     * @param Order $orderUuid
     * @return Factory|View
     * @throws Exception
     */
    public function status(Order $orderUuid)
    {
        $result = $this->paymentService->validate($orderUuid);

        if ($result === true) {
            $this->orderService->sendPaymentConfirmationToCustomer($orderUuid);
        }

        return view('site::shop.thankyou', [
            'order' => $orderUuid,
        ]);
    }

    /**
     * @param CartService $cartService
     * @param PostCheckoutRequest $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function process(CartService $cartService, PostCheckoutRequest $request)
    {
        /** @var CartService $cart */
        $cart = $cartService;

        // Validate and apply coupon code if given
        $couponCode = $cart->discounts()->where('coupon_code', '!=', null)->first();
        if ($couponCode !== null) {
            $coupon = $this->couponCodeService->validateCouponCode($couponCode->coupon_code);
            if ($coupon === null) {
                if ($request->wantsJson()) {
                    return response()->json(['status' => 'error', 'message' => __('Coupon code invalid.')]);
                }
                return redirect()
                    ->back()
                    ->withErrors(['coupon_code' => __('Coupon code invalid.')]);
            }
            $couponStatus = $this->couponCodeService->applyCouponCode($coupon);
        }

        if ($request->wantsJson()) {
            return response()->json($couponStatus);
        }

        // Save customer details
        $customer = $this->customerService->saveCustomer();

        // Save billing
        $this->customerService->saveContact($customer, $request->all(), 'billing');

        // Save shipping
        if (isset($request->ship_different_address) && (int)$request->ship_different_address === 1) {
            $this->customerService->saveContact($customer, $request->all(), 'shipping', false);
        }

        // Save order
        $order = $this->orderService->saveOrderByCart($cart, $customer);

        $this->orderService->sendOrderConfirmationToCustomer($order);

        $order->selected_method = $request->payment;

        // Generate payment request
        $this->paymentService->generate($order);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'url' => route('shop.order.pay', ['orderUuid' => $order->uuid, 'payment_link' => $order->payment_link])]);
        }

        return redirect()
            ->to(route('shop.order.pay', ['orderUuid' => $order->uuid, 'payment_link' => $order->payment_link]));
    }

    /**
     * @param ShopCalculationService $shopCalculationService
     * @param Order $orderUuid
     * @return Factory|View
     */
    public function paymentRedirect(ShopCalculationService $shopCalculationService, Order $orderUuid)
    {
        $shopCalculationService->setCollection($orderUuid->items);

        return view('site::shop.summary', [
            'payment_link' => request()->payment_link,
            'order' => $orderUuid,
            'vats' => $shopCalculationService->vats(),
            'subtotal' => $shopCalculationService->subtotal(),
            'fees' => $shopCalculationService->grossServiceFee(),
            'total_before_discount' => $shopCalculationService->totalBeforeDiscount(),
            'total' => $shopCalculationService->total(),
        ]);
    }

    /**
     * @param Order $orderUuid
     * @return string
     */
    public function invoice(Order $orderUuid)
    {
        return $this->orderService->invoicePdf($orderUuid);
    }
}
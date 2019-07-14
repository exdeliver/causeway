<?php

namespace Exdeliver\Causeway\Controllers\Shop;

use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Services\CartService;
use Exdeliver\Causeway\Domain\Services\CouponCodeService;
use Exdeliver\Causeway\Requests\PostOrderRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class CartController
 * @package App\Http\Controllers
 */
class CartController extends Controller
{
    /**
     * @var CartService
     */
    protected $cartService;

    /**
     * @var CouponCodeService
     */
    protected $couponCodeService;

    /**
     * CartController constructor.
     * @param CartService $cartService
     * @param CouponCodeService $couponCodeService
     */
    public function __construct(CartService $cartService, CouponCodeService $couponCodeService)
    {
        $this->cartService = $cartService;
        $this->couponCodeService = $couponCodeService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function addProduct(Request $request)
    {
        foreach ($request->products as $productId => $quantity) {
            $this->cartService->validateAndAddToCart($productId, $quantity);
        }

        return $this->index();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function addShippingMethod(Request $request)
    {
        $this->cartService->validateShippingMethodAndAddToCart($request->shippingMethod['id'], 1);

        return $this->index();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(json_decode($this->cartService->summary()));
    }

    /**
     * @param PostOrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cart(PostOrderRequest $request)
    {
        // Reserve products by quantity.
        return redirect()
            ->to(route('shop.checkout'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function couponcode(Request $request)
    {
        $coupon = $this->couponCodeService->validateCouponCode($request->coupon_code);

        if ($coupon === null) {

            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => __('Coupon code invalid.')]);
            }

            return redirect()
                ->back()
                ->withErrors(['coupon_code' => __('Coupon code invalid.')]);
        }

        $couponStatus = $this->couponCodeService->applyCouponCode($coupon);

        if ($request->wantsJson()) {
            return response()->json($couponStatus);
        }

        return redirect()
            ->back()
            ->with('status', $couponStatus['message']);
    }

    /**
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function clear(Request $request)
    {
        $this->cartService->clear();

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => __('Cart cleared')]);
        }

        return redirect()
            ->back()
            ->with('status', __('Cart cleared'));
    }
}
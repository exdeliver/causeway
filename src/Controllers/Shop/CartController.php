<?php

namespace Exdeliver\Causeway\Controllers\Shop;

use Exception;
use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Cart\Domain\Services\CartService;
use Exdeliver\Causeway\Domain\Entities\Shop\Product;
use Exdeliver\Causeway\Domain\Entities\Shop\ShippingMethods\ShippingMethods;
use Exdeliver\Causeway\Domain\Services\CouponCodeService;
use Exdeliver\Causeway\Requests\PostOrderRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class CartController.
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
     *
     * @param CartService       $cartService
     * @param CouponCodeService $couponCodeService
     */
    public function __construct(CartService $cartService, CouponCodeService $couponCodeService)
    {
        $this->cartService = $cartService;
        $this->couponCodeService = $couponCodeService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function addProduct(Request $request)
    {
        foreach ($request->products as $productId => $quantity) {
            $product = Product::findOrFail($productId);

            $this->cartService->validateAndAddToCart([
                'product_id' => $product->id,
                'name' => $product->title,
                '_link' => route('shop.product', ['slug' => $product->slug]),
                'type' => 'item',
                'gross_price' => (null !== $product->special_price && $product->special_price > 0 && $product->gross_price > $product->special_price) ? $product->special_price : $product->gross_price,
                'vat' => $product->vat,
            ], $quantity);
        }

        return $this->index();
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function addShippingMethod(Request $request)
    {
        $this->validateShippingMethodAndAddToCart($request->shippingMethod['id'], 1);

        return $this->index();
    }

    /**
     * @param string $shippingMethodId
     * @param int    $quantity
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function validateShippingMethodAndAddToCart(string $shippingMethodId, int $quantity = 1)
    {
        $shippingMethod = ShippingMethods::findOrFail($shippingMethodId);

        $findExistingProduct = $this->cartService->find([
            'type' => 'shippingmethod',
        ]);

        if (count($findExistingProduct) > 0) {
            foreach ($findExistingProduct as $product) {
                $this->cartService->remove((string) $product->id);
            }
        }

        // Apply free shipping when threshold reached.
        if ((null !== $shippingMethod->total_free_shipping_threshold && $shippingMethod->total_free_shipping_threshold > 0) && $this->cartService->subtotal() > $shippingMethod->total_free_shipping_threshold) {
            $shippingMethod->gross_price = 0;
        }

        $productData = [
            'product_id' => $shippingMethodId,
            'name' => $shippingMethod->label,
            'type' => 'shippingmethod',
            'gross_price' => $shippingMethod->gross_price,
            'special_price' => ($shippingMethod->special_price > 0 && $shippingMethod->special_price < $shippingMethod->gross_price) ? $shippingMethod->special_price : null,
            'vat' => $shippingMethod->vat,
            'quantity' => $quantity,
        ];

        $this->cartService->add($productData);

        return $shippingMethod;
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(json_decode($this->cartService->summary()));
    }

    /**
     * @param PostOrderRequest $request
     *
     * @return RedirectResponse
     */
    public function cart(PostOrderRequest $request)
    {
        // Reserve products by quantity.
        return redirect()
            ->to(route('shop.checkout'));
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function couponcode(Request $request)
    {
        $coupon = $this->couponCodeService->validateCouponCode($request->coupon_code);

        if (null === $coupon) {
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
     *
     * @return JsonResponse|RedirectResponse
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

<?php

namespace Exdeliver\Causeway\Controllers\Shop;

use Exdeliver\Cart\Domain\Services\CartService;
use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\Shop\Category;
use Exdeliver\Causeway\Domain\Entities\Shop\Product;
use Exdeliver\Causeway\Domain\Services\MolliePaymentService;
use Exdeliver\Causeway\Domain\Services\PaymentService;
use Exdeliver\Causeway\Domain\Services\ShippingMethodService;
use Exdeliver\Causeway\Domain\Services\ShopProductService;
use Illuminate\Http\Request;

/**
 * Class ShopController
 * @package App\Http\Controllers\Shop
 */
class ShopController extends Controller
{
    const DEFAULT_PAGINATOR_SIZE = 25;

    /**
     * @var CartService
     */
    protected $cartService;

    /**
     * @var ShopProductService
     */
    protected $productService;

    /**
     * @var PaymentService
     */
    protected $paymentService;

    /**
     * @var ShippingMethodService
     */
    protected $shippingService;

    /**
     * ShopController constructor.
     * @param CartService $cartService
     * @param ShopProductService $productService
     * @param MolliePaymentService $paymentService
     * @param ShippingMethodService $shippingMethodService
     */
    public function __construct(CartService $cartService, ShopProductService $productService, MolliePaymentService $paymentService, ShippingMethodService $shippingMethodService)
    {
        $this->cartService = $cartService;
        $this->productService = $productService;
        $this->paymentService = $paymentService;
        $this->shippingService = $shippingMethodService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('causeway::shop.index');
    }

    /**
     * @param Request $request
     * @param Category $shopCategorySlug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function getCategory(Request $request, Category $shopCategorySlug)
    {
        $numberOfColumns = $request->numberOfColumns ?? 4;

        if (!in_array($numberOfColumns, [2, 4, 6, 8, 10])) {
            throw new \Exception('Un-allowed column number.');
        }

        $bootstrapColWidth = 12 / $numberOfColumns;

        $products = $this->productService->queryProducts($shopCategorySlug, $request);
        $activeFilters = $this->productService->getActiveFilters();

        return view('causeway::shop.category', [
            'category' => $shopCategorySlug,
            'products' => $products->paginate($request->numberPerPage ?? self::DEFAULT_PAGINATOR_SIZE),
            'numberOfColumns' => $numberOfColumns,
            'bootstrapColWidth' => $bootstrapColWidth,
            'activeFilters' => $activeFilters ?? [],
        ]);
    }

    /**
     * @param Product $shopProductSlug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProduct(Product $shopProductSlug)
    {
        return view('causeway::shop.product', [
            'product' => $shopProductSlug,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCart()
    {
        return view('causeway::shop.cart', [
            'products' => $this->cartService->all(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function getCheckout()
    {
        if (count($this->cartService->items()) <= 0) {
            return redirect()
                ->back()
                ->withErrors(['cart' => __('No items in cart.')]);
        }

        return view('causeway::shop.checkout', [
            'products' => $this->cartService->all(),
            'paymentMethods' => $this->paymentService->getClient()->methods->all(),
            'shippingMethods' => $this->shippingService->repository->all(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getThankYou()
    {
        $this->cartService->clear();
        return view('causeway::shop.thankyou');
    }
}
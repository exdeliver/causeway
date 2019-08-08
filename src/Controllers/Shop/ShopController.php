<?php

namespace Exdeliver\Causeway\Controllers\Shop;

use Exception;
use Exdeliver\Cart\Domain\Services\CartService;
use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\Shop\Category;
use Exdeliver\Causeway\Domain\Entities\Shop\Filters\QueryBuilder;
use Exdeliver\Causeway\Domain\Entities\Shop\Product;
use Exdeliver\Causeway\Domain\Services\MolliePaymentService;
use Exdeliver\Causeway\Domain\Services\PaymentService;
use Exdeliver\Causeway\Domain\Services\ShippingMethodService;
use Exdeliver\Causeway\Domain\Services\ShopProductService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Mollie\Api\Exceptions\ApiException;

/**
 * Class ShopController.
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
     *
     * @param CartService           $cartService
     * @param ShopProductService    $productService
     * @param MolliePaymentService  $paymentService
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
     * @return Factory|View
     */
    public function index()
    {
        return view()->first(['site::shop.index', 'site::shop.index']);
    }

    /**
     * @param Request  $request
     * @param Category $shopCategorySlug
     *
     * @return Factory|View
     *
     * @throws Exception
     */
    public function getCategory(Request $request, Category $shopCategorySlug)
    {
        $numberOfColumns = $request->numberOfColumns ?? 4;

        if (!in_array($numberOfColumns, [2, 4, 6, 8, 10])) {
            throw new Exception('Un-allowed column number.');
        }

        $bootstrapColWidth = 12 / $numberOfColumns;

        $products = $this->productService->queryProducts($shopCategorySlug, $request);

        $products = new QueryBuilder($request, $products);

        $activeFilters = $products->getFilters();
        $products = $products->getQuery();

        $pagination = $products->paginate($request->numberPerPage ?? self::DEFAULT_PAGINATOR_SIZE);

        $customView = 'site::shop.category';

        return view()->first([$customView, 'site::shop.category'], [
            'category' => $shopCategorySlug,
            'products' => $pagination,
            'numberOfColumns' => $numberOfColumns,
            'bootstrapColWidth' => $bootstrapColWidth,
            'activeFilters' => $activeFilters ?? [],
        ]);
    }

    /**
     * @param Product $shopProductSlug
     *
     * @return Factory|View
     */
    public function getProduct(Product $shopProductSlug)
    {
        $customView = 'site::shop.product';

        return view()->first([$customView, 'site::shop.product'], [
            'product' => $shopProductSlug,
        ]);
    }

    /**
     * @return Factory|View
     */
    public function getCart()
    {
        $customView = 'site::shop.cart';

        return view()->first([$customView, 'site::shop.cart'], [
            'products' => $this->cartService->all(),
        ]);
    }

    /**
     * @return Factory|View
     *
     * @throws ApiException
     */
    public function getCheckout()
    {
        if (count($this->cartService->items()) <= 0) {
            return redirect()
                ->back()
                ->withErrors(['cart' => __('No items in cart.')]);
        }

        $customView = 'site::shop.checkout';

        return view()->first([$customView, 'site::shop.checkout'], [
            'products' => $this->cartService->all(),
            'paymentMethods' => $this->paymentService->getClient()->methods->all(),
            'shippingMethods' => $this->shippingService->repository->all(),
        ]);
    }

    /**
     * @return Factory|View
     */
    public function getThankYou()
    {
        $this->cartService->clear();
        $customView = 'site::shop.thankyou';

        return view()->first([$customView, 'causeway::shop.thankyou']);
    }
}

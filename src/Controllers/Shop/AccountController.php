<?php

namespace Exdeliver\Causeway\Controllers\Shop;

use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Cart\Domain\Services\CartService;
use Exdeliver\Causeway\Domain\Services\ShopProductService;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class AccountController.
 */
class AccountController extends Controller
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
     * @return Factory|View
     */
    public function getOrders()
    {
        return view('site::shop.account.orders');
    }
}

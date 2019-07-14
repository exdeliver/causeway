<?php

namespace Exdeliver\Causeway\Controllers\Shop;

use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Cart\Domain\Services\CartService;
use Exdeliver\Causeway\Domain\Services\ShopProductService;

/**
 * Class AccountController
 * @package App\Http\Controllers\Shop
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getOrders()
    {
        return view('causeway::shop.account.orders');
    }
}
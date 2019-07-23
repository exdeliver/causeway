<?php

namespace Exdeliver\Causeway\Controllers\Admin\Shop;

use Exdeliver\Causeway\Controllers\Controller;

/**
 * Class DashboardController
 * @package Exdeliver\Causeway\Controllers\Admin\Shop
 */
final class DashboardController extends Controller
{
    public const DEFAULT_PAGINATOR_SIZE = 50;

    /**
     * Get Dashboard index
     */
    public function index()
    {
        return view('causeway::admin.shop.dashboard');
    }
}
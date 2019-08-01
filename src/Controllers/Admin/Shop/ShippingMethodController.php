<?php

namespace Exdeliver\Causeway\Controllers\Admin\Shop;

use Exception;
use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\Shop\ShippingMethods\ShippingMethods;
use Exdeliver\Causeway\Domain\Services\ShippingMethodService;
use Exdeliver\Causeway\Domain\Services\ShopProductService;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class ShippingMethodController.
 */
final class ShippingMethodController extends Controller
{
    public const DEFAULT_PAGINATOR_SIZE = 50;

    /**
     * @var ShopProductService
     */
    protected $shippingMethodService;

    /**
     * ProductController constructor.
     *
     * @param ShippingMethodService $shippingMethodService
     */
    public function __construct(ShippingMethodService $shippingMethodService)
    {
        $this->shippingMethodService = $shippingMethodService;
    }

    /**
     * Products index.
     */
    public function index()
    {
        return view('causeway::admin.shop.shippingMethod.index');
    }

    /**
     * Get Datatables.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function getAjaxShippingMethods()
    {
        $products = ShippingMethods::get();

        return Datatables::of($products)
            ->addColumn('name', function ($row) {
                return $row->label;
            })
            ->addColumn('gross_price', function ($row) {
                return $row->gross_price ? money($row->gross_price, 'EUR')->format() : 'Free';
            })
            ->addColumn('vat_price', function ($row) {
                return $row->vat_price ? money($row->vat_price, 'EUR')->format() : 'Free';
            })
            ->addColumn('max_weight', function ($row) {
                return $row->max_weight;
            })
            ->addColumn('service', function ($row) {
                return $row->service;
            })
            ->addColumn('manage', function ($row) {
                $menuRemoval = '<form action="'.route('admin.shop.shipping-method.destroy', ['id' => $row->id]).'" method="post" class="delete-inline">
                            '.method_field('DELETE').csrf_field().'
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</button>
                        </form>';

                return '<a href="'.route('admin.shop.shipping-method.update', ['id' => $row->id]).'" class="btn btn-sm btn-warning">Edit</a>'.
                    $menuRemoval;
            })
            ->rawColumns(['pid', 'name', 'gross_price', 'vat_price', 'service', 'manage'])
            ->make(true);
    }
}

<?php

namespace Exdeliver\Causeway\Controllers\Admin\Shop;

use Carbon\Carbon;
use Exdeliver\Cart\Domain\Services\ShopCalculationService;
use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\Shop\Orders\Order;
use Exdeliver\Causeway\Requests\PostOrderStatusRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class OrderController
 * @package Exdeliver\Causeway\Controllers\Admin\Shop
 */
final class OrderController extends Controller
{
    public const DEFAULT_PAGINATOR_SIZE = 50;

    /**
     * @var ShopCalculationService
     */
    protected $calculationService;

    /**
     * OrderController constructor.
     * @param ShopCalculationService $shopCalculationService
     */
    public function __construct(ShopCalculationService $shopCalculationService)
    {
        $this->calculationService = $shopCalculationService;
    }

    /**
     * Orders index
     */
    public function index()
    {
        return view('causeway::admin.shop.order.index');
    }

    /**
     * @param PostOrderStatusRequest $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function status(PostOrderStatusRequest $request, Order $order)
    {
        $order->status = $request->status;
        $order->updated_at = Carbon::now();
        $order->save();

        return redirect()
            ->back()
            ->with('status', 'Order id: ' . $order->id . ' status updated');
    }

    /**
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Order $order)
    {
        $this->calculationService->setCollection($order->items);

        return view('causeway::admin.shop.order.show', [
            'order' => $order,
            'subtotal' => $this->calculationService->subtotal(),
            'vats' => $this->calculationService->vats(),
            'total' => $this->calculationService->total(),
            'invoiceContact' => $order->customer->primaryContact(),
            'shippingContact' => $order->customer->shippingContact(),
        ]);
    }

    /**
     * Get Datatables.
     *
     * @return mixed
     * @throws \Exception
     */
    public function getAjaxOrders()
    {
        /** @var Order $orders */
        $orders = Order::query();

        return Datatables::eloquent($orders)
            ->orderColumns(['id'], '-:column $1')

            ->addColumn('id', function ($row) {
                return '<a href="' . route('admin.shop.order.show', [
                        'id' => $row->id,
                    ]) . '">' . $row->id . '</a>';
            })
            ->addColumn('name', function ($row) {
                return $row->customer->primaryContact()->full_name;
            })
            ->addColumn('price', function ($row) {
                $price = '<span>' . money($row->mollie_payment_total, 'EUR')->format() . '</span>&nbsp;';
                $price .= $row->is_paid ? '<span class="badge badge-success">Paid</span>' : '<span class="badge badge-danger">Unpaid</span>';
                return $price;
            })
            ->addColumn('status', function ($row) {
                $statusForm = '<form action="' . route('admin.shop.order.status', ['id' => $row->id]) . '" method="post">';
                $statusForm .= csrf_field();
                $statusForm .= '<select name="status" onchange="this.form.submit();">';
                foreach (Order::getOrderStatuses() as $orderStatus) {
                    $selected = $row->status === $orderStatus ? 'selected="selected"' : '';
                    $statusForm .= '<option value="' . $orderStatus . '" ' . $selected . '>' . ucwords(str_replace('_', ' ', $orderStatus)) . '</option>';
                }
                $statusForm .= '</select>';
                return $statusForm;
            })
            ->addColumn('created_at', function ($row) {
                return causewayDate($row->created_at, 'j M Y H:i');
            })
            ->addColumn('manage', function ($row) {
                $menuRemoval = '<form action="' . route('admin.shop.order.destroy', ['id' => $row->id]) . '" method="post" class="delete-inline">
                            ' . method_field('DELETE') . csrf_field() . '
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</button>
                        </form>';

                return '<a href="' . route('admin.shop.order.update', ['id' => $row->id]) . '" class="btn btn-sm btn-warning">Edit</a>';

            })
            ->rawColumns(['id', 'name', 'price', 'status', 'created_at', 'manage'])
            ->toJson();
    }
}
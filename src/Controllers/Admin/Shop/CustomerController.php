<?php

namespace Exdeliver\Causeway\Controllers\Admin\Shop;

use Exception;
use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\Shop\Customers\Customer;
use Exdeliver\Causeway\Domain\Services\CustomerService;
use Yajra\DataTables\Facades\DataTables;

final class CustomerController extends Controller
{
    public const DEFAULT_PAGINATOR_SIZE = 50;

    /**
     * @var CustomerService
     */
    protected $customerService;

    /**
     * CustomerController constructor.
     *
     * @param CustomerService $customerService
     */
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Customers index.
     */
    public function index()
    {
        return view('causeway::admin.shop.customer.index');
    }

    /**
     * Get Datatables.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function getAjaxCustomers()
    {
        $customers = Customer::get();

        return Datatables::of($customers)
            ->addColumn('id', function ($row) {
                return $row->id;
            })
            ->addColumn('name', function ($row) {
                return $row->primaryContact()->full_name;
            })
            ->addColumn('orders', function ($row) {
                return count($row->orders);
            })
            ->addColumn('manage', function ($row) {
                $menuRemoval = '<form action="'.route('admin.menu.remove', ['id' => $row->id]).'" method="post" class="delete-inline">
                            '.method_field('DELETE').csrf_field().'
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</button>
                        </form>';

                return '<a href="'.route('admin.menu.show', ['id' => $row->id]).'" class="btn btn-sm btn-primary">Manage</a>
                        <a href="'.route('admin.menu.update', ['id' => $row->id]).'" class="btn btn-sm btn-warning">Edit</a>'.
                    $menuRemoval;
            })
            ->rawColumns(['label', 'name', 'items', 'manage'])
            ->make(true);
    }
}

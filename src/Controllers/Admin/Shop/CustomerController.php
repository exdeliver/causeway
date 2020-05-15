<?php

namespace Exdeliver\Causeway\Controllers\Admin\Shop;

use Exception;
use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\Shop\Customers\Customer;
use Exdeliver\Causeway\Domain\Services\CustomerService;
use Exdeliver\Causeway\Requests\PostCustomerRequest;
use Exdeliver\Causeway\Requests\PostShopProductRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;
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
     * @param Request $request
     *
     * @return Factory|View
     *
     * @throws Exception
     */
    public function create(Request $request)
    {
        return view('causeway::admin.shop.customer.new', [
        ]);
    }

    /**
     * @param Request $request
     * @param Customer $customer
     *
     * @return Factory|View
     */
    public function edit(Request $request, Customer $customer)
    {
        return view('causeway::admin.shop.customer.update', [
            'customer' => $customer,
        ]);
    }

    /**
     * @param PostCustomerRequest $request
     * @param Customer $customer
     * @return RedirectResponse
     *
     * @throws Throwable
     */
    public function update(PostCustomerRequest $request, Customer $customer)
    {
        return $this->store($request, $customer);
    }


    /**
     * @param PostCustomerRequest $request
     * @param Customer|null $customer
     * @return RedirectResponse
     *
     * @throws Throwable
     */
    public function store(PostCustomerRequest $request, Customer $customer = null)
    {
        try {
            $customer = DB::transaction(function () use ($request, $customer) {

                if ($customer === null) {
                    $customer = $this->customerService->saveCustomer($customer);
                }

                return $this->customerService->saveContact($customer, $request->all());
            });
        } catch (Exception $e) {
            throw new Exception($e);
        }

        if (null !== $customer) {
            $request->session()->flash('status', 'Customer updated');
        } else {
            $request->session()->flash('status', 'Customer created');
        }

        return redirect()
            ->to(route('admin.shop.customer.update', ['id' => $customer->id]));
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
                $menuRemoval = '<form action="' . route('admin.shop.customer.destroy', ['id' => $row->id]) . '" method="post" class="delete-inline">
                            ' . method_field('DELETE') . csrf_field() . '
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</button>
                        </form>';

                return '<a href="' . route('admin.shop.customer.update', ['id' => $row->id]) . '" class="btn btn-sm btn-warning">Edit</a>' .
                    $menuRemoval;
            })
            ->rawColumns(['label', 'name', 'items', 'manage'])
            ->make(true);
    }
}

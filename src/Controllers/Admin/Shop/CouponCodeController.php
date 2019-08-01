<?php

namespace Exdeliver\Causeway\Controllers\Admin\Shop;

use Exception;
use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\Shop\Category;
use Exdeliver\Causeway\Domain\Entities\Shop\CouponCode;
use Exdeliver\Causeway\Domain\Entities\Shop\Product;
use Exdeliver\Causeway\Domain\Services\CouponCodeService;
use Exdeliver\Causeway\Requests\PostCouponCodeRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class CouponCodeController.
 */
final class CouponCodeController extends Controller
{
    public const DEFAULT_PAGINATOR_SIZE = 50;

    /**
     * @var CouponCodeService
     */
    protected $couponCodeService;

    /**
     * CategoryController constructor.
     *
     * @param CouponCodeService $couponCodeService
     */
    public function __construct(CouponCodeService $couponCodeService)
    {
        $this->couponCodeService = $couponCodeService;
    }

    /**
     * Category index.
     */
    public function index()
    {
        return view('causeway::admin.shop.couponcode.index');
    }

    /**
     * Create category.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('causeway::admin.shop.couponcode.new', [
            'categories' => Category::getSelectListHierarchy(),
            'products' => Product::get(),
        ]);
    }

    /**
     * @param Request    $request
     * @param CouponCode $couponcode
     *
     * @return Factory|View
     */
    public function edit(Request $request, CouponCode $couponcode)
    {
        return view('causeway::admin.shop.couponcode.update', [
            'couponCode' => $couponcode,
            'categories' => Category::getSelectListHierarchy(),
            'products' => Product::get(),
        ]);
    }

    /**
     * @param PostCouponCodeRequest $request
     * @param CouponCode            $couponcode
     *
     * @return RedirectResponse
     */
    public function update(PostCouponCodeRequest $request, CouponCode $couponcode)
    {
        return $this->store($request, $couponcode);
    }

    /**
     * @param PostCouponCodeRequest $request
     * @param CouponCode|null       $couponcode
     *
     * @return RedirectResponse
     */
    public function store(PostCouponCodeRequest $request, CouponCode $couponcode = null)
    {
        $couponcode = $this->couponCodeService->save($request->except(['categories', 'products', 'files']), $couponcode->id ?? null);

        // Apply couponcode on categories and products.
        $couponcode->categories()->sync($request->categories ?? []);
        $couponcode->products()->sync($request->products ?? []);

        if (null !== $couponcode) {
            $request->session()->flash('status', 'Coupon code '.$couponcode->coupon_code.' updated');
        } else {
            $request->session()->flash('status', 'Coupon code '.$couponcode->coupon_code.' created');
        }

        return redirect()
            ->to(route('admin.shop.couponcode.index'));
    }

    /**
     * @param Request    $request
     * @param CouponCode $couponcode
     *
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(Request $request, CouponCode $couponcode)
    {
        $couponcode->delete();

        return redirect()->back();
    }

    /**
     * Get Datatables.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function getAjaxCouponCodes()
    {
        $category = CouponCode::get();

        return Datatables::of($category)
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('coupon_code', function ($row) {
                return $row->coupon_code;
            })
            ->addColumn('status', function ($row) {
                return null;
            })
            ->addColumn('manage', function ($row) {
                $menuRemoval = '<form action="'.route('admin.shop.couponcode.destroy', ['id' => $row->id]).'" method="post" class="delete-inline">
                            '.method_field('DELETE').csrf_field().'
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</button>
                        </form>';

                return '<a href="'.route('admin.shop.couponcode.update', ['id' => $row->id]).'" class="btn btn-sm btn-warning">Edit</a>'.
                    $menuRemoval;
            })
            ->rawColumns(['name', 'coupon_code', 'status', 'manage'])
            ->make(true);
    }
}

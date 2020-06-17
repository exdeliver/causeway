<?php

namespace Exdeliver\Causeway\Controllers\Admin\Shop;

use Exception;
use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\Shop\Category;
use Exdeliver\Causeway\Domain\Entities\Shop\Product;
use Exdeliver\Causeway\Domain\Services\ProductBookingsService;
use Exdeliver\Causeway\Domain\Services\ProductVariantsService;
use Exdeliver\Causeway\Domain\Services\ShopProductService;
use Exdeliver\Causeway\Requests\PostShopProductRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class ProductController.
 */
final class ProductController extends Controller
{
    public const DEFAULT_PAGINATOR_SIZE = 50;

    /**
     * @var ShopProductService
     */
    protected $productService;

    /**
     * @var ProductVariantsService
     */
    protected $productVariantService;

    /**
     * @var ProductBookingsService
     */
    protected $productBookingService;

    /**
     * ProductController constructor.
     *
     * @param ShopProductService     $productService
     * @param ProductVariantsService $productVariantsService
     * @param ProductBookingsService $productBookingsService
     */
    public function __construct(ShopProductService $productService, ProductVariantsService $productVariantsService, ProductBookingsService $productBookingsService)
    {
        $this->productService = $productService;
        $this->productVariantService = $productVariantsService;
        $this->productBookingService = $productBookingsService;
    }

    /**
     * Products index.
     */
    public function index()
    {
        return view('causeway::admin.shop.product.index');
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
        $productType = collect(Product::getProductTypes())->where('type', $request->product_type ?? 'regular')->first();

        if (null === $productType) {
            throw new Exception('Unsupported product type');
        }

        return view('causeway::admin.shop.product.new', [
            'categories' => Category::getSelectListHierarchy(),
            'productType' => $productType['type'],
        ]);
    }

    /**
     * @param Request $request
     * @param Product $product
     *
     * @return Factory|View
     */
    public function edit(Request $request, Product $product)
    {
        return view('causeway::admin.shop.product.update', [
            'categories' => Category::getSelectListHierarchy(),
            'product' => $product,
            'productType' => $product->type,
        ]);
    }

    /**
     * @param PostShopProductRequest $request
     * @param Product                $product
     *
     * @return RedirectResponse
     *
     * @throws Throwable
     */
    public function update(PostShopProductRequest $request, Product $product)
    {
        return $this->store($request, $product);
    }

    /**
     * @param PostShopProductRequest $request
     * @param Product|null           $product
     *
     * @return RedirectResponse
     *
     * @throws Throwable
     */
    public function store(PostShopProductRequest $request, Product $product = null)
    {
        try {
            $product = DB::transaction(function () use ($request, $product) {
                /** @var Product $product */
                $product = $this->productService->saveProduct($request->except(['files', 'categories', 'vat_price', 'variant', 'variantProduct', 'booking']), $product->id ?? null);

                if (is_array($request->variant)) {
                    $variants = $this->productVariantService->saveVariants($request->only('variant', 'variantProduct'), $product);
                }
                if (is_array($request->booking)) {
                    $bookings = $this->productBookingService->saveBookings($request->only('booking'), $product);
                }

                // Display product on categories.
                $product->categories()->sync($request->categories);

                return $product;
            });
        } catch (Exception $e) {
            throw new Exception($e);
        }

        if (null !== $product) {
            $request->session()->flash('status', 'Product '.$product->title.' updated');
        } else {
            $request->session()->flash('status', 'Product '.$product->title.' created');
        }

        return redirect()
            ->to(route('admin.shop.product.update', ['product' => $product->id]));
    }

    /**
     * Get Datatables.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function getAjaxProducts()
    {
        $filteredTypes = array_column(collect(Product::getProductTypes())
            ->whereNotIn('type', ['variant'])
            ->toArray(), 'type');
        $products = Product::whereIn('type', $filteredTypes)->get();

        return Datatables::of($products)
            ->addColumn('pid', function ($row) {
                return $row->pid;
            })
            ->addColumn('name', function ($row) {
                return $row->title;
            })
            ->addColumn('gross_price', function ($row) {
                return money($row->gross_price, 'EUR')->format();
            })
            ->addColumn('vat_price', function ($row) {
                return money($row->vat_price, 'EUR')->format();
            })
            ->addColumn('vat', function ($row) {
                return $row->vat + 0 .'%';
            })
            ->addColumn('manage', function ($row) {
                $menuRemoval = '<form action="'.route('admin.shop.product.destroy', ['product' => $row->id]).'" method="post" class="delete-inline">
                            '.method_field('DELETE').csrf_field().'
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</button>
                        </form>';

                return '<a href="'.route('admin.shop.product.update', ['product' => $row->id]).'" class="btn btn-sm btn-warning">Edit</a>'.
                    $menuRemoval;
            })
            ->rawColumns(['pid', 'name', 'gross_price', 'vat_price', 'vat', 'manage'])
            ->make(true);
    }
}

<?php

namespace Exdeliver\Causeway\Controllers\Admin\Shop;

use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\Shop\Category;
use Exdeliver\Causeway\Domain\Entities\Shop\Product;
use Exdeliver\Causeway\Domain\Services\ShopProductService;
use Exdeliver\Causeway\Requests\PostShopProductRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class ProductController
 * @package Exdeliver\Causeway\Controllers\Admin\Shop
 */
final class ProductController extends Controller
{
    public const DEFAULT_PAGINATOR_SIZE = 50;

    /**
     * @var ShopProductService
     */
    protected $productService;

    /**
     * ProductController constructor.
     * @param ShopProductService $productService
     */
    public function __construct(ShopProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Products index
     */
    public function index()
    {
        return view('causeway::admin.shop.product.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $productType = collect(Product::getProductTypes())->where('type', $request->product_type ?? 'regular')->first();

        if ($productType === null) {
            throw new \Exception('Unsupported product type');
        }

        return view('causeway::admin.shop.product.new', [
            'categories' => Category::getSelectListHierarchy(),
            'productType' => $productType['type'],
        ]);
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostShopProductRequest $request, Product $product)
    {
        return $this->store($request, $product);
    }

    /**
     * @param PostShopProductRequest $request
     * @param Product|null $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostShopProductRequest $request, Product $product = null)
    {
        /** @var Product $product */
        $product = $this->productService->saveProduct($request->except(['files', 'categories', 'vat_price']), $product->id ?? null);

        // Display product on categories.
        $product->categories()->sync($request->categories);

        if ($product !== null) {
            $request->session()->flash('status', 'Product ' . $product->title . ' updated');
        } else {
            $request->session()->flash('status', 'Product ' . $product->title . ' created');
        }

        return redirect()
            ->to(route('admin.shop.product.index'));
    }

    /**
     * Get Datatables.
     *
     * @return mixed
     * @throws \Exception
     */
    public function getAjaxProducts()
    {
        $products = Product::get();

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
                return $row->vat + 0 . '%';
            })
            ->addColumn('manage', function ($row) {
                $menuRemoval = '<form action="' . route('admin.shop.product.destroy', ['id' => $row->id]) . '" method="post" class="delete-inline">
                            ' . method_field('DELETE') . csrf_field() . '
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</button>
                        </form>';

                return '<a href="' . route('admin.shop.product.update', ['id' => $row->id]) . '" class="btn btn-sm btn-warning">Edit</a>' .
                    $menuRemoval;

            })
            ->rawColumns(['pid', 'name', 'gross_price', 'vat_price', 'vat', 'manage'])
            ->make(true);
    }

}
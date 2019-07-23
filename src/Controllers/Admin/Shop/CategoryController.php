<?php

namespace Exdeliver\Causeway\Controllers\Admin\Shop;

use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\Shop\Category;
use Exdeliver\Causeway\Domain\Services\ShopCategoryService;
use Exdeliver\Causeway\Requests\PostShopCategoryRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class CategoryController
 * @package Exdeliver\Causeway\Controllers\Admin\Shop
 */
final class CategoryController extends Controller
{
    public const DEFAULT_PAGINATOR_SIZE = 50;

    /**
     * @var ShopCategoryService
     */
    protected $categoryService;

    /**
     * CategoryController constructor.
     * @param ShopCategoryService $shopCategoryService
     */
    public function __construct(ShopCategoryService $shopCategoryService)
    {
        $this->categoryService = $shopCategoryService;
    }

    /**
     * Category index
     */
    public function index()
    {
        return view('causeway::admin.shop.category.index');
    }

    /**
     * Create category.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('causeway::admin.shop.category.new', [
            'categories' => Category::get()->pluck('title', 'id')->toArray() ?? [],
        ]);
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, Category $category)
    {
        return view('causeway::admin.shop.category.update', [
            'category' => $category,
            'categories' => Category::get()->pluck('title', 'id')->toArray() ?? [],
        ]);
    }

    /**
     * @param PostShopCategoryRequest $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostShopCategoryRequest $request, Category $category)
    {
        return $this->store($request, $category);
    }

    /**
     * @param PostShopCategoryRequest $request
     * @param Category|null $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostShopCategoryRequest $request, Category $category = null)
    {
        $category = $this->categoryService->saveCategory($request->except(['files']), $category->id ?? null);

        if ($category !== null) {
            $request->session()->flash('status', 'Category ' . $category->title . ' updated');
        } else {
            $request->session()->flash('status', 'Category ' . $category->title . ' created');
        }

        return redirect()
            ->to(route('admin.shop.category.index'));
    }

    /**
     * Move categories to order by direction buttons.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sortCategory(Request $request): \Illuminate\Http\RedirectResponse
    {
        if (!isset($request->direction, $request->category)) {
            return abort(404, 'Invalid...');
        }

        $category = Category::findOrFail($request->category);

        $sequence = $this->categoryService->setCategorySequence($request->direction, $category);

        return redirect()
            ->back();
    }


    /**
     * Get Datatables.
     *
     * @return mixed
     * @throws \Exception
     */
    public function getAjaxCategories()
    {
        $category = Category::whereNull('parent_id')->get();

        return Datatables::of($category)
            ->addColumn('title', function ($row) {
                return $row->title;
            })
            ->addColumn('products', function ($row) {
                return count($row->products);
            })
            ->addColumn('subcategory', function ($row) {
                $html = '<ul class="list-group sortableNav">';
                foreach ($row->children as $child) {
                    $html .= '<li class="list-group-item list-group-item-action" id="item-' . $child->id . '"><span>' . $child->title . ' (' . count($child->products) . ')</span>';
                    $html .= '<div class="pull-right">
                                <ul class="up-down-chevron-btns">';
                    if (!isset($child->sequence) || $row->children()->min('sequence') !== $child->sequence) {
                        $html .= '<li><a href="' . route('admin.shop.category.index.sort', ['category' => $child->id, 'direction' => 'up']) . '"><i class="fa fa-chevron-up"></i></a></li>';
                    }
                    if (!isset($child->sequence) || $row->children()->max('sequence') !== $child->sequence) {
                        $html .= '<li><a href="' . route('admin.shop.category.index.sort', ['category' => $child->id, 'direction' => 'down']) . '"><i class="fa fa-chevron-down"></i></a></li>';
                    }
                    $html .= '</ul>
                                </div>
                                <div class="pull-right">
                                <a href="' . route('admin.shop.category.update', ['id' => $child->id]) . '" class="btn btn-sm btn-warning">Edit</a>
                        <form action="' . route('admin.shop.category.destroy', ['id' => $child->id]) . '" method="DELETE" class="delete-inline">
                            ' . method_field('DELETE') . csrf_field() . '
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</button>
                        </form>
                                </div>';
                    $html .= '</li>';
                }

                $html .= '</ul>';

                return $html;
            })
            ->addColumn('manage', function ($row) {
                $menuRemoval = '<form action="' . route('admin.shop.category.destroy', ['id' => $row->id]) . '" method="post" class="delete-inline">
                            ' . method_field('DELETE') . csrf_field() . '
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</button>
                        </form>';

                return '<a href="' . route('admin.shop.category.update', ['id' => $row->id]) . '" class="btn btn-sm btn-warning">Edit</a>' .
                    $menuRemoval;

            })
            ->rawColumns(['title', 'products', 'subcategory', 'manage'])
            ->make(true);
    }
}
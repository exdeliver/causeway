<?php

namespace Exdeliver\Causeway\Controllers\Admin;

use Exception;
use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\Menu\Menu;
use Exdeliver\Causeway\Domain\Entities\Menu\MenuItem;
use Exdeliver\Causeway\Domain\Services\MenuService;
use Exdeliver\Causeway\Requests\PostMenuItemRequest;
use Exdeliver\Causeway\Requests\PostMenuRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class MenuController.
 */
class MenuController extends Controller
{
    /**
     * @var MenuService
     */
    protected $menuService;

    /**
     * MenuController constructor.
     *
     * @param MenuService $menuService
     */
    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('causeway::admin.menu.index');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('causeway::admin.menu.new');
    }

    /**
     * @param Request $request
     * @param Menu    $menu
     *
     * @return Factory|View
     */
    public function edit(Request $request, Menu $menu)
    {
        return view('causeway::admin.menu.update', [
            'menu' => $menu,
        ]);
    }

    /**
     * @param Request $request
     * @param Menu    $menu
     *
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(Request $request, Menu $menu)
    {
        $menu->delete();

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param Menu    $menu
     *
     * @return Factory|View
     */
    public function show(Request $request, Menu $menu)
    {
        return view('causeway::admin.menu.show', [
            'menu' => $menu,
        ]);
    }

    /**
     * @param PostMenuRequest $request
     * @param Menu            $menu
     */
    public function update(PostMenuRequest $request, Menu $menu)
    {
        $page = $this->store($request, $menu);
    }

    /**
     * @param PostMenuRequest $request
     * @param Menu|null       $menu
     *
     * @return RedirectResponse
     */
    public function store(PostMenuRequest $request, Menu $menu = null)
    {
        $this->menuService->updateOrCreate([
            'id' => $menu->id ?? null,
        ], $request->only([
            'name',
            'label',
        ]));

        $request->session()->flash('status', isset($menu->id) && null !== $menu->id ? 'Menu has successfully been updated!' : 'Menu has successfully been created!');

        return redirect()
            ->route('admin.menu.index');
    }

    /**
     * @param Request $request
     * @param Menu    $menu
     *
     * @return Factory|View
     */
    public function createItem(Request $request, Menu $menu)
    {
        return view('causeway::admin.menu.item.new', [
            'menu' => $menu,
        ]);
    }

    /**
     * @param Request  $request
     * @param Menu     $menu
     * @param MenuItem $item
     *
     * @return Factory|View
     */
    public function editItem(Request $request, Menu $menu, MenuItem $item)
    {
        $item = $this->getTranslatedResult($request, $item);

        return view('causeway::admin.menu.item.update', [
            'menu' => $menu,
            'item' => $item,
        ]);
    }

    /**
     * @param PostMenuItemRequest $request
     * @param Menu                $menu
     * @param MenuItem            $item
     *
     * @return RedirectResponse
     */
    public function updateItem(PostMenuItemRequest $request, Menu $menu, MenuItem $item)
    {
        return $this->storeItem($request, $menu, $item);
    }

    /**
     * @param PostMenuItemRequest $request
     * @param Menu                $menu
     * @param MenuItem|null       $item
     *
     * @return RedirectResponse
     */
    public function storeItem(PostMenuItemRequest $request, Menu $menu, MenuItem $item = null)
    {
        $request->request->add(['menu_id' => $menu->id]);

        $this->menuService->updateOrCreateItem($request, $item->id ?? null);

        return redirect()
            ->route('admin.menu.show', ['id' => $menu->id]);
    }

    /**
     * @param Request  $request
     * @param Menu     $menu
     * @param MenuItem $item
     *
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroyItem(Request $request, Menu $menu, MenuItem $item)
    {
        if ($item->items) {
            foreach ($item->items as $child) {
                $child->parent_id = null;
                $child->save();
            }
        }
        $item->delete();

        return redirect()->back();
    }

    /**
     * Get Datatables.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function getAjaxMenu()
    {
        $menu = Menu::get();

        return Datatables::of($menu)
            ->addColumn('label', function ($row) {
                return $row->label;
            })
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('items', function ($row) {
                return count($row->items);
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

    /**
     * @param Request $request
     * @param Menu    $menu
     *
     * @return false|string
     */
    public function sort(Request $request, Menu $menu)
    {
        $items = $request->data;
        $items = json_decode($items);

        foreach ($items as $position => $item) {
            $item = (object) $item;
            if (isset($item->id)) {
                $condition = MenuItem::where('menu_id', $menu->id)->findOrFail($item->id);
                $condition->sequence = $item->left;
                $condition->parent_id = $item->parent_id;
                $condition->save();
            }
        }

        return json_encode(['status' => true]);
    }
}

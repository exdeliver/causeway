<?php

namespace Exdeliver\Causeway\Controllers\Admin;

use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\Forum\Category;
use Exdeliver\Causeway\Domain\Services\ForumService;
use Exdeliver\Causeway\Requests\PostForumCategoryRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class MenuController
 * @package Exdeliver\Causeway\Controllers\Admin
 */
class ForumController extends Controller
{
    /** @var ForumService */
    protected $forumService;

    /**
     * EventController constructor.
     * @param ForumService $forumService
     */
    public function __construct(ForumService $forumService)
    {
        $this->forumService = $forumService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.forum.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.forum.new', [
            'forumCategories' => Category::getParents()->pluck('title', 'id')->toArray(),
        ]);
    }

    /**
     * @param Request $request
     * @param Category $forum
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, Category $forum)
    {
        return view('admin.forum.update', [
            'forumCategories' => Category::getParents()->pluck('title', 'id')->toArray(),
            'category' => $forum,
        ]);
    }

    /**
     * @param PostForumCategoryRequest $request
     * @param Category $forum
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostForumCategoryRequest $request, Category $forum)
    {
        return $this->store($request, $forum);
    }

    /**
     * @param PostForumCategoryRequest $request
     * @param Category|null $forum
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostForumCategoryRequest $request, Category $forum = null)
    {
        $this->forumService->updateOrCreateCategory([
            'id' => $forum->id ?? null,
        ], $request->only([
            'title',
            'slug',
            'description',
            'parent_id',
            'sequence',
        ]));

        $request->session()->flash('status', isset($forum->id) && $forum->id !== null ? 'Category has successfully been updated!' : 'Category has successfully been created!');

        return redirect()
            ->route('admin.forum.index');
    }

    /**
     * @param Request $request
     * @param Category $forum
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, Category $forum)
    {
        $forum->delete();

        return redirect()
            ->back();
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

        $sequence = $this->forumService->setCategorySequence($request->direction, $category);

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
        $categories = Category::getParents()->get();

        return Datatables::of($categories)
            ->addColumn('title', function ($row) {
                return $row->title;
            })
            ->addColumn('subcategory', function ($row) {
                $html = '<ul class="list-group sortableNav">';
                foreach ($row->children as $child) {
                    $html .= '<li class="list-group-item list-group-item-action" id="item-' . $child->id . '"><span>' . $child->title . '</span>';
                    $html .= '<div class="pull-right">
                                <ul class="up-down-chevron-btns">';
                    if (!isset($child->sequence) || $row->children()->min('sequence') !== $child->sequence) {
                        $html .= '<li><a href="' . route('admin.forum.index.sort', ['category' => $child->id, 'direction' => 'up']) . '"><i class="fa fa-chevron-up"></i></a></li>';
                    }
                    if (!isset($child->sequence) || $row->children()->max('sequence') !== $child->sequence) {
                        $html .= '<li><a href="' . route('admin.forum.index.sort', ['category' => $child->id, 'direction' => 'down']) . '"><i class="fa fa-chevron-down"></i></a></li>';
                    }
                    $html .= '</ul>
                                </div>
                                <div class="pull-right">
                                <a href="' . route('admin.forum.update', ['id' => $child->id]) . '" class="btn btn-sm btn-warning">Edit</a>
                        <form action="' . route('admin.forum.remove', ['id' => $child->id]) . '" method="DELETE" class="delete-inline">
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
                return '<a href="' . route('admin.forum.update', ['id' => $row->id]) . '" class="btn btn-sm btn-warning">Edit</a>
                        <form action="' . route('admin.forum.remove', ['id' => $row->id]) . '" method="post" class="delete-inline">
                            ' . method_field('DELETE') . csrf_field() . '
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</button>
                        </form>
                        ';
            })
            ->rawColumns(['title', 'subcategory', 'manage'])
            ->make(true);
    }
}
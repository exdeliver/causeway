<?php

namespace Exdeliver\Causeway\Controllers\Admin;

use Exception;
use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\Page\Page;
use Exdeliver\Causeway\Domain\Services\PageService;
use Exdeliver\Causeway\Requests\PostPageRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
{
    /**
     * @var PageService
     */
    protected $pageService;

    /**
     * PageController constructor.
     *
     * @param PageService $pageService
     */
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('causeway::admin.pages.index');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('causeway::admin.pages.new');
    }

    /**
     * @param Request $request
     * @param Page    $page
     *
     * @return Factory|View
     */
    public function edit(Request $request, Page $page)
    {
        $page = $this->getTranslatedResult($request, $page);

        return view('causeway::admin.pages.update', [
            'page' => $page,
        ]);
    }

    /**
     * @param PostPageRequest $request
     * @param Page            $page
     *
     * @return Model
     */
    public function update(PostPageRequest $request, Page $page)
    {
        return $this->store($request, $page);
    }

    /**
     * @param PostPageRequest $request
     * @param Page|null       $page
     *
     * @return Model
     */
    public function store(PostPageRequest $request, Page $page = null)
    {
        $savedPage = $this->pageService->savePage($request, $page->id ?? null);

        if (null !== $page) {
            $message = 'Page '.$savedPage->name.' updated';
        } else {
            $message = 'Page '.$savedPage->name.' created';
        }
        $request->session()->flash('status', $message);

        return redirect()
            ->to(route('admin.pages.update', ['id' => $savedPage->id]));
    }

    /**
     * @param Request $request
     * @param Page    $page
     *
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(Request $request, Page $page)
    {
        $page->delete();

        return redirect()->back();
    }

    /**
     * Get Datatables.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function getAjaxPages()
    {
        $pages = Page::get();

        return Datatables::of($pages)
            ->addColumn('name', function ($row) {
                return '<a href="'.url($row->slug ?? '/').'" target="_blank">'.$row->name.' <i class="fa fa-external-link"></i></a>';
            })
            ->addColumn('url', function ($row) {
                return $row->slug;
            })
            ->addColumn('access_level', function ($row) {
                return $row->access_level;
            })
            ->addColumn('manage', function ($row) {
                return '<a href="'.route('admin.pages.update', ['id' => $row->id]).'" class="btn btn-sm btn-warning">Edit</a>
                        <form action="'.route('admin.pages.destroy', ['id' => $row->id]).'" class="delete-inline" method="post">
                            '.method_field('DELETE').csrf_field().'
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</button>
                        </form>
                        ';
            })
            ->rawColumns(['name', 'url', 'access_level', 'manage'])
            ->make(true);
    }
}

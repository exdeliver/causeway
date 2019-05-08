<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exdeliver\Causeway\Infrastructure\Repositories\PageRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

/**
 * Class PageService
 * @package Domain\Services
 */
class PageService extends AbstractService
{
    /**
     * PageService constructor.
     * @param PageRepository $pageRepository
     */
    public function __construct(PageRepository $pageRepository)
    {
        $this->repository = $pageRepository;
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return Model
     */
    public function savePage(Request $request, int $id = null)
    {
        $language = $request->language ?? Lang::locale();

        $request->request->add(['user_id' => auth()->user()->id,
            $language => $request->only(['name', 'subtitle', 'slug', 'content', 'meta_title', 'meta_description', 'tags']),
        ]);

        return $this->repository->updateOrCreateTranslation(
            $id,
            $request->only(['user_id', 'access_level', $language]),
            $language
        );
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function getPage(string $slug)
    {
        return $this->repository->where('slug', '=', $slug)->firstOrFail();
    }
}

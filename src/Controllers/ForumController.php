<?php

namespace Exdeliver\Causeway\Controllers;

use Exdeliver\Causeway\Domain\Entities\Comment\Comment;
use Exdeliver\Causeway\Domain\Entities\Forum\Category;
use Exdeliver\Causeway\Domain\Entities\Forum\Thread;
use Exdeliver\Causeway\Domain\Services\ForumService;
use Exdeliver\Causeway\Domain\Services\GroupService;
use Exdeliver\Causeway\Requests\PostNewThreadRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class GroupController.
 */
class ForumController extends Controller
{
    /**
     * @var GroupService
     */
    private $forumService;

    /**
     * GroupController constructor.
     *
     * @param ForumService $forumService
     */
    public function __construct(ForumService $forumService)
    {
        $this->forumService = $forumService;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('site::forum.index', [
            'forumCategories' => $this->forumService->getActiveCategories(),
        ]);
    }

    /**
     * @param Request  $request
     * @param Category $forumCategory
     *
     * @return Factory|View
     */
    public function getCategory(Request $request, Category $forumCategory)
    {
        return view('site::forum.threadList', [
            'category' => $forumCategory,
            'threads' => $forumCategory->threads()->orderBy('forum_threads.created_at', 'desc')->paginate(25),
        ]);
    }

    /**
     * @param Request  $request
     * @param Category $forumCategory
     *
     * @return Factory|View
     */
    public function getNewThread(Request $request, Category $forumCategory)
    {
        return view('site::forum.newThread', [
            'category' => $forumCategory,
        ]);
    }

    /**
     * @param PostNewThreadRequest $request
     * @param Category             $forumCategory
     * @param Thread|null          $item
     *
     * @return RedirectResponse
     */
    public function postNewThread(PostNewThreadRequest $request, Category $forumCategory, Thread $item = null)
    {
        $request->request->add([
            'category_id' => $forumCategory->id,
        ]);

        $thread = $this->forumService->updateOrCreateThread([
            'id' => $item->id ?? null,
        ], $request->only(['title', 'slug', 'content', 'category_id']));

        $request->session()->flash('status', isset($item->id) && null !== $item->id ? 'Thread has successfully been updated!' : 'Thread has successfully been created!');

        return redirect()
            ->route('site.forum.thread', [
                'forumCategory' => $forumCategory->slug,
                'forumThread' => $thread->slug,
            ]);
    }

    /**
     * @param Request  $request
     * @param Category $forumCategory
     * @param Thread   $forumThread
     *
     * @return Factory|View
     */
    public function getThread(Request $request, Category $forumCategory, Thread $forumThread)
    {
        return view('site::forum.thread', [
            'category' => $forumCategory,
            'thread' => $forumThread,
        ]);
    }

    /**
     * Get quote by comment.
     *
     * @param Request $request
     *
     * @return JsonResponse|void
     */
    public function getQuoteByComment(Request $request)
    {
        if (!isset($request->comment_id)) {
            return abort(404);
        }

        $comment = Comment::findOrFail($request->comment_id);

        return response()->json(['status' => true, 'comment' => strip_tags($comment->comment, '<br /><p><b><strong><u><ul><li><ol>'), 'name' => $comment->name, 'date' => cmsDateTime($comment->created_at)]);
    }
}

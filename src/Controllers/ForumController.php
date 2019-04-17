<?php

namespace Exdeliver\Causeway\Controllers;

use Exdeliver\Causeway\Domain\Entities\Comment\Comment;
use Exdeliver\Causeway\Domain\Entities\Forum\Category;
use Exdeliver\Causeway\Domain\Entities\Forum\Thread;
use Exdeliver\Causeway\Domain\Services\ForumService;
use Exdeliver\Causeway\Domain\Services\GroupService;
use Exdeliver\Causeway\Requests\PostNewThreadRequest;
use Illuminate\Http\Request;

/**
 * Class GroupController
 * @package Exdeliver\Causeway\Controllers
 */
class ForumController extends Controller
{
    /**
     * @var GroupService $groupService
     */
    private $forumService;

    /**
     * GroupController constructor.
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
        $pageView = 'causeway::forum.index';

        if (view()->exists('forum.custom.index')) {
            $pageView = 'forum.custom.index';
        }

        return view($pageView, [
            'forumCategories' => $this->forumService->getActiveCategories(),
        ]);
    }

    /**
     * @param Request $request
     * @param Category $forumCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCategory(Request $request, Category $forumCategory)
    {
        $pageView = 'causeway::forum.threadList';

        if (view()->exists('forum.custom.threadList')) {
            $pageView = 'forum.custom.threadList';
        }

        return view($pageView, [
            'category' => $forumCategory,
            'threads' => $forumCategory->threads()->orderBy('forum_threads.created_at', 'desc')->paginate(25),
        ]);
    }

    /**
     * @param Request $request
     * @param Category $forumCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getNewThread(Request $request, Category $forumCategory)
    {
        return view('causeway::forum.newThread', [
            'category' => $forumCategory,
        ]);
    }

    /**
     * @param PostNewThreadRequest $request
     * @param Category $forumCategory
     * @param Thread|null $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postNewThread(PostNewThreadRequest $request, Category $forumCategory, Thread $item = null)
    {
        $request->request->add([
            'category_id' => $forumCategory->id,
        ]);

        $thread = $this->forumService->updateOrCreateThread([
            'id' => $item->id ?? null,
        ], $request->only(['title', 'slug', 'content', 'category_id']));

        $request->session()->flash('status', isset($item->id) && $item->id !== null ? 'Thread has successfully been updated!' : 'Thread has successfully been created!');

        return redirect()
            ->route('site.forum.thread', [
                'forumCategory' => $forumCategory->slug,
                'forumThread' => $thread->slug,
            ]);
    }

    /**
     * @param Request $request
     * @param Category $forumCategory
     * @param Thread $forumThread
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getThread(Request $request, Category $forumCategory, Thread $forumThread)
    {
        $pageView = 'causeway::forum.thread';

        if (view()->exists('forum.custom.thread')) {
            $pageView = 'forum.custom.thread';
        }

        return view($pageView, [
            'category' => $forumCategory,
            'thread' => $forumThread,
        ]);
    }

    /**
     * Get quote by comment.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
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

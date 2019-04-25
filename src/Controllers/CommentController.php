<?php

namespace Exdeliver\Causeway\Controllers;

use App\Models\Notification;
use Carbon\Carbon;
use Exdeliver\Causeway\Domain\Entities\Forum\Thread;
use Exdeliver\Causeway\Domain\Services\CommentService;
use Exdeliver\Causeway\Requests\PostCommentRequest;

/**
 * Class CommentController
 * @package Exdeliver\Causeway\Controllers\
 */
class CommentController extends Controller
{
    /**
     * @var CommentService
     */
    protected $commentService;

    /**
     * CommentController constructor.
     * @param CommentService $commentService
     */
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @param PostCommentRequest $request
     * @param string $type
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment(PostCommentRequest $request, string $type, string $id)
    {
        switch ($type) {
            case 'groupNotification':
                $notification = Notification::where('id', $id)->firstOrFail();
                $result = auth()->user()->commentOn($notification, $id, [
                    'comment' => clean($request->comment),
                    'profile_picture' => '/images/' . auth()->user()->profile_picture,
                    'name' => auth()->user()->name,
                ]);
                break;
            case 'Comment':
                break;
            case 'photoAlbumComment':
                break;
            case 'photoComment':
                break;
            case str_replace('Exdeliver\Causeway\\', '', Thread::class):
                $thread = Thread::find($id);
                $result = auth()->user()->commentOn($thread, $id, [
                    'comment' => $request->comment,
                    'formatted_date' => Carbon::now()->diffForHumans(),
                    'profile_picture' => '/images/' . auth()->user()->profile_picture,
                    'name' => auth()->user()->name,
                ]);
                break;
        }

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        $request->session()->flash('info', 'Comment posted.');

        return redirect()
            ->back();
    }
}
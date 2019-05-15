<?php

namespace Exdeliver\Causeway\Domain\Services;

use App\Models\Notification;
use Exdeliver\Causeway\Domain\Entities\Comment\Comment;
use Exdeliver\Causeway\Domain\Entities\PandaComment\PandaComment;

/**
 * Class PandaLikeService
 *
 * @package Domain\Services
 */
final class LikeService extends AbstractService
{
    /**
     * @var array
     */
    public $likeAbleTypes;

    /**
     * PandaLikeService constructor.
     */
    public function __construct()
    {
        $this->likeAbleTypes = [
            'groupNotification',
            'comment',
        ];
    }

    /**
     * Like subject by type and id.
     *
     * @param string $type
     * @param string $id
     * @throws \Exception
     */
    public function likeSubjectByTypeAndId(string $type, string $id)
    {
        $user = auth()->user();

        switch ($type) {
            case 'groupNotification':
                $notification = Notification::where('id', $id)->firstOrFail();
                auth()->user()->liking($notification);
                break;
            case 'comment':
                $comment = Comment::where('id', $id)->firstOrFail();
                if ($user->likes($comment)) {
                    $user->unlike($comment);
                } else {
                    $user->like($comment);
                }

                break;
        }
    }
}

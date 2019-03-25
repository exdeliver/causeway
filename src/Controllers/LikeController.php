<?php

namespace Exdeliver\Causeway\Controllers;

use Exdeliver\Causeway\Domain\Services\LikeService;
use Illuminate\Http\Request;

/**
 * Class LikeController
 *
 * @package Exdeliver\Causeway\Controllers\
 */
class LikeController extends Controller
{
    protected $likeService;

    /**
     * LikeController constructor.
     *
     * @param LikeService $likeService
     */
    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    /**
     * Like action.
     *
     * @param Request $request
     * @param string $type
     * @param string $id
     * @return bool
     * @throws \Exception
     */
    public function like(Request $request, string $type, string $id)
    {
        if (!in_array($type, $this->likeService->likeAbleTypes, true)) {
            throw new \Exception('This subject type is not supported...');
        }

        $this->likeService->likeSubjectByTypeAndId($type, $id);

        return response()
            ->json(['status' => true]);
    }
}
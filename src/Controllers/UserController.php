<?php

namespace Exdeliver\Causeway\Controllers;

use Exdeliver\Causeway\Domain\Services\GroupService;
use Exdeliver\Causeway\Domain\Services\UserService;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package Exdeliver\Causeway\Controllers\
 */
class UserController extends Controller
{
    /**
     * @var GroupService
     */
    protected $groupService;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * UserController constructor.
     *
     * @param GroupService $groupService
     * @param UserService $userService
     */
    public function __construct(GroupService $groupService, UserService $userService)
    {
        $this->groupService = $groupService;
        $this->userService = $userService;
    }

    /**
     * Reset points.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function reset(Request $request)
    {
        $userId = auth()->user()->id;

        $groups = $this->userService->findGroupsByUserId($userId);

        $this->groupService->clearPointsByUser($userId, $groups);

        $request->session()->flash('info', 'Resetted points.');

        return redirect()
            ->back();
    }
}

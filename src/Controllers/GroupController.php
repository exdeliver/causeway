<?php

namespace Exdeliver\Causeway\Controllers;

use DataTables;
use Exdeliver\Causeway\Domain\Entities\Group\Group;
use Exdeliver\Causeway\Domain\Entities\Group\GroupRole;
use Exdeliver\Causeway\Domain\Services\GroupService;
use Exdeliver\Causeway\Requests\PostGroupRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Class GroupController
 * @package Exdeliver\Causeway\Controllers
 */
class GroupController extends Controller
{
    /**
     * @var GroupService $groupService
     */
    private $groupService;

    /**
     * GroupController constructor.
     * @param GroupService $groupService
     */
    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $groups = $this->groupService->groupsByAuthenticatedUser()->get();

        return view('Group.index', [
            'groups' => $groups,
        ]);
    }

    /**
     * Get group by label.
     *
     * @param string $label
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $label)
    {
        $group = $this->groupService->getGroupByLabelAndAuthenticatedUser($label);

        return view('Group.show', [
            'group' => $group,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('Group.create');
    }

    /**
     * @param Group $Group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Group $Group)
    {
        $this->authorize('manage', $Group);

        return view('Group.edit', ['group' => $Group]);
    }

    /**
     * @param PostGroupRequest $request
     * @param Group|null $Group
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(PostGroupRequest $request, Group $Group = null): RedirectResponse
    {
        $group = $this->groupService->saveGroup([
            'name' => $request->name,
            'label' => str_slug($request->name),
        ], $Group->id ?? null);

        $users = $request->users ?? [['user_id' => auth()->user()->id, 'role_id' => GroupRole::where('label', 'admin')->first()->id]];

        $this->groupService->addUsersToGroup($users, $group);

        $request->session()->flash('status', isset($Group->id) && $Group->id !== null ? 'Group has successfully been updated!' : 'Group has successfully been created!');

        return redirect()
            ->route('group.show', ['label' => $group->label]);
    }

    /**
     * Group invitation.
     *
     * @param Request $request
     * @param string $label
     * @param string $code
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function invite(Request $request, string $label, string $code)
    {
        try {
            $group = $this->groupService->getGroupByLabelAndUuid($label, $code);
            if (empty($request->referral_user_id) && $group->findUserInGroup((int)Hashids::decode($request->referral_user_id)) === false) {
                return abort('404');
            }
        } catch (\Exception $e) {
            return abort('404');
        }

        if (!auth()->check()) {

            $request->session()->flash('info', 'You need to be logged in.');

            return redirect()->route('login');
        }

        if ($group->findUserInGroup(auth()->user()->id)) {

            $request->session()->flash('info', 'You are already a member of this group.');

            return redirect()->route('group.index');
        }

        // Add user as member.
        $this->groupService->addUsersToGroup([['user_id' => auth()->user()->id, 'role_id' => GroupRole::where('label', 'member')->first()->id]], $group);

        $request->session()->flash('info', 'You have successfully joined group: ' . $group->name);

        return redirect()
            ->route('group.show', ['label' => $group->label]);
    }

    /**
     * @param Request $request
     * @param Group $Group
     * @return RedirectResponse
     * @throws \Exception
     */
    public function remove(Request $request, Group $Group)
    {
        $this->groupService->deleteGroupAndUsers($Group);

        $request->session()->flash('status', 'Successfully deleted group');

        return redirect()
            ->back();
    }

    /**
     * @param Request $request
     * @param Group $Group
     * @param int $userId
     * @return RedirectResponse
     */
    public function removeUserFromGroup(Request $request, Group $Group, int $userId)
    {
        $this->groupService->deleteUsersFromGroup($Group, [$userId]);

        $request->session()->flash('status', 'Successfully deleted user from group');

        return redirect()
            ->back();
    }

    /**
     * AJAX DataTables
     * Get users by group.
     *
     * @param string $label
     * @return mixed
     * @throws \Exception
     */
    public function getUsersOverviewGroup(string $label)
    {
        $group = $this->groupService->getGroupByLabelAndAuthenticatedUser($label);

        return Datatables::of($group->users()->get())
            ->addColumn('name', function ($row) {
                return $row->user->name;
            })
            ->addColumn('email', function ($row) {
                return $row->user->email;
            })
            ->addColumn('points', function ($row) {
                return $row->user->points()->sum('amount');
            })
            ->addColumn('manage', function ($row) {
                if (auth()->user()->can('manage', $row->group) && auth()->user()->can('group.manage')) {
                    return '<a href="' . route('group.remove.user', ['Group' => $row->group, 'id' => $row->user->id]) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</a>';
                }
            })
            ->rawColumns(['manage'])
            ->make(true);
    }

    /**
     * AJAX DataTables
     * Get groups by user.
     *
     * @return mixed
     * @throws \Exception
     */
    public function getGroupsByUser()
    {
        $groups = $this->groupService->groupsByAuthenticatedUser()->get();

        return Datatables::of($groups)
            ->addColumn('name', function ($row) {
                return '<a href="' . route('group.show', ['label' => $row->label]) . '">' . $row->name . '</a>';
            })
            ->addColumn('members', function ($row) {
                return $row->users->count();
            })
            ->addColumn('manage', function ($row) {
                if (auth()->user()->can('manage', $row) && auth()->user()->can('group.manage')) {
                    return '<a href="' . route('group.edit', ['id' => $row->_group_id]) . '" class="btn btn-sm btn-primary">Edit</a>
                        <a href="' . route('group.remove', ['id' => $row->_group_id]) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</a>';
                }
            })
            ->rawColumns(['name', 'manage'])
            ->make(true);
    }
}
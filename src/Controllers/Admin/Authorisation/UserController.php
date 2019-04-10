<?php

namespace Exdeliver\Causeway\Controllers\Admin\Authorisation;

use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\User\User;
use Exdeliver\Causeway\Domain\Services\UserService;
use Exdeliver\Causeway\Requests\PostAdminUserRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class UserController
 * @package Exdeliver\Causeway\Controllers\Admin\Authorisation
 */
class UserController extends Controller
{
    /** @var UserService */
    protected $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('causeway::admin.authorisation.users.index');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $roles = Role::get();
        return view('causeway::admin.authorisation.users.new', [
            'roles' => $roles,
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Factory|View
     */
    public function edit(Request $request, User $user)
    {
        $roles = Role::get();
        return view('causeway::admin.authorisation.users.update', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * @param PostAdminUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostAdminUserRequest $request, User $user)
    {
        return $this->store($request, $user);
    }

    /**
     * @param PostAdminUserRequest $request
     * @param User|null $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostAdminUserRequest $request, User $user = null)
    {
        $this->userService->updateOrCreateWithRoles([
            'id' => $user->id ?? null,
        ], $request);

        $request->session()->flash('status', isset($user->id) && $user->id !== null ? 'User has successfully been updated!' : 'User has successfully been created!');

        return redirect()
            ->route('admin.authorisation.user.index');
    }

    /**
     * Get Datatables.
     *
     * @return mixed
     * @throws \Exception
     */
    public function getAjaxUsers()
    {
        $users = config('auth.providers.users.model')::get();

        return Datatables::of($users)
            ->addColumn('name', function (User $row) {
                $state = $row->hasVerifiedEmail() ? '<span class="badge badge-success">verified</span>' : '<span class="badge badge-warning">in-active</span>';
                return $row->name . ' ' . $state;
            })
            ->addColumn('email', function ($row) {
                return $row->email;
            })
            ->addColumn('role', function ($row) {
                return implode(', ', array_column($row->roles->toArray(), 'name'));
            })
            ->addColumn('manage', function ($row) {
                $userRemoval = !$row->hasRole('admin') ? '<form action="' . route('admin.authorisation.user.remove', ['id' => $row->id]) . '" method="post" class="delete-inline">
                            ' . method_field('DELETE') . csrf_field() . '
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</button>
                        </form>' : '';

                return '<a href="' . route('admin.authorisation.user.update', ['id' => $row->id]) . '" class="btn btn-sm btn-warning">Edit</a>' .
                    $userRemoval;
            })
            ->rawColumns(['name', 'email', 'role', 'manage'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return redirect()
            ->back();
    }
}
<?php

namespace Exdeliver\Causeway\Controllers\Admin\Authorisation;

use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\User\User;
use Exdeliver\Causeway\Domain\Services\UserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

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

    public function store()
    {

    }

    /**
     * Get Datatables.
     *
     * @return mixed
     * @throws \Exception
     */
    public function getAjaxUsers()
    {
        $users = User::get();

        return Datatables::of($users)
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('email', function ($row) {
                return $row->email;
            })
            ->addColumn('role', function ($row) {
                return implode(', ', array_column($row->roles->toArray(), 'name'));
            })
            ->addColumn('manage', function ($row) {
                $userRemoval = '<form action="' . route('admin.authorisation.user.remove', ['id' => $row->id]) . '" method="post" class="delete-inline">
                            ' . method_field('DELETE') . csrf_field() . '
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</button>
                        </form>';

                return '<a href="' . route('admin.authorisation.user.update', ['id' => $row->id]) . '" class="btn btn-sm btn-warning">Edit</a>
                        $userRemoval
                        ';
            })
            ->rawColumns(['name', 'email', 'role', 'manage'])
            ->make(true);
    }
}
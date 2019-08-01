<?php

namespace Exdeliver\Causeway\Controllers\Admin\Authorisation;

use Exception;
use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Services\RoleService;
use Exdeliver\Causeway\Domain\Services\UserService;
use Exdeliver\Causeway\Requests\PostAdminRoleRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class RoleController.
 */
class RoleController extends Controller
{
    /** @var UserService */
    protected $roleService;

    /**
     * UserController constructor.
     *
     * @param RoleService $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('causeway::admin.authorisation.roles.index');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $permissions = Permissions::get();

        return view('causeway::admin.authorisation.roles.new', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * @param Request $request
     * @param Role    $role
     *
     * @return Factory|View
     */
    public function edit(Request $request, Role $role)
    {
        $permissions = Permission::get();

        return view('causeway::admin.authorisation.roles.update', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    /**
     * @param PostAdminRoleRequest $request
     * @param Role                 $role
     *
     * @return RedirectResponse
     */
    public function update(PostAdminRoleRequest $request, Role $role)
    {
        return $this->store($request, $role);
    }

    /**
     * @param PostAdminRoleRequest $request
     * @param Role|null            $role
     *
     * @return RedirectResponse
     */
    public function store(PostAdminRoleRequest $request, Role $role = null)
    {
        $this->roleService->updateOrCreateWithPermissions([
            'id' => $role->id ?? null,
        ], $request);

        $request->session()->flash('status', isset($role->id) && null !== $role->id ? 'Role has successfully been updated!' : 'Role has successfully been created!');

        return redirect()
            ->route('admin.authorisation.role.index');
    }

    /**
     * Get Datatables.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function getAjaxRoles()
    {
        $users = Role::get();

        return Datatables::of($users)
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('manage', function (Role $row) {
                $roleRemoval = 'admin' !== $row->name ? '<form action="'.route('admin.authorisation.role.remove', ['id' => $row->id]).'" method="post" class="delete-inline">
                            '.method_field('DELETE').csrf_field().'
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</button>
                        </form>' : '';

                return '<a href="'.route('admin.authorisation.role.update', ['id' => $row->id]).'" class="btn btn-sm btn-warning">Edit</a>'.
                    $roleRemoval;
            })
            ->rawColumns(['name', 'email', 'role', 'manage'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @param Role    $role
     *
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(Request $request, Role $role)
    {
        $role->delete();

        return redirect()
            ->back();
    }
}

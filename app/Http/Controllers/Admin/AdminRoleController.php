<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreAdminRoleRequest;
use App\Http\Requests\Role\UpdateAdminRoleRequest;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminRoleController extends Controller
{
    public function __construct(protected RoleService $roleService) {}
    public function index()
    {
        $roles = $this->roleService->getAll();
        $permissions = Permission::where('guard_name', 'admin')->get();
        return view('admin.pages.Roles.index', compact('roles', 'permissions'));
    }
    public function store(StoreAdminRoleRequest $request)
    {
        $this->roleService->createRoleWithPermission(
            $request->name,
            $request->permissions,
            'admin'
        );
        return redirect()->route('admin.roles.index')->with('success', trans('errors.success'));
    }

    public function update(UpdateAdminRoleRequest $request, Role $role)
    {
        $this->roleService->updateRolePermissions(
            $role,
            $request->name,
            $request->permissions
        );

        return back()->with('success', __('general.role_updated'));
    }

    public function destroy(Role $role)
    {
        $result = $this->roleService->deleteRole($role);
        if($result){
            return redirect()
            ->route('admin.roles.index')
            ->with('success', __('errors.deleted'));
        }else{
            return redirect()->back()->with('error',trans('errors.role.role_has_admins'));
        }


        
    }
}

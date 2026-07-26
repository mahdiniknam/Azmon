<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Models\Admin;
use App\Services\AdminService;
use App\Services\RoleService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        protected AdminService $adminService,
        protected RoleService $roleService,
    ) {}
    public function index()
    {
        $admins = $this->adminService->index();
        $filters = [
            ['name' => 'user', 'label' => trans('general.search_admin'), 'type' => 'text', 'placeholder' => trans('general.enter_admin')],
            // ['name' => 'user', 'label' => trans('general.status'),'type' => 'select','placeholder' => trans('general.enter_user')]
        ];
        return view('admin.pages.admins.list', compact('admins', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.admins.create', [
            'roles' => $this->roleService->getAll()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $this->adminService->store($request->validated());

        return redirect()->route('admin.admins.index')->with('success', trans('errors.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        return view('admin.pages.admins.edit', [
            'roles' => $this->roleService->getAll(),
            'admin' => $admin
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $adminService = $this->adminService->update($request->validated(), $admin);
        return redirect()->route('admin.admins.index')->with('success', trans('errors.success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        if ($admin->isSuperAdmin()) {
            return redirect()->back()->with('error', trans('errors.super_admin_cannot_be_deleted'));
        }
        $admin->roles()->detach();
        $admin->delete();
        return back()->with('success', trans('errors.success'));
    }
}

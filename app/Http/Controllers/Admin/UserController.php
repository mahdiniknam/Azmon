<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Country;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService,
    ) {}
    // لیست کاربران
    public function index()
    {
        $users = $this->userService->index();
        $filters = [
            ['name' => 'user', 'label' => trans('general.search_user'), 'type' => 'text', 'placeholder' => trans('general.enter_user')],
            // ['name' => 'user', 'label' => trans('general.status'),'type' => 'select','placeholder' => trans('general.enter_user')]
        ];
        return view('admin.pages.users.list', compact('users', 'filters'));
    }

    // فرم ثبت کاربر
    public function create()
    {

        return view('admin.pages.users.create');
    }

    //نمایش کاربر وااحد
    public function show(User $user)
    {
        $countries = Country::get()->toArray();
        return view('admin.pages.users.edit', compact(['user', 'countries']));
    }
    // ذخیره کاربر جدید
    public function store(StoreUserRequest $request)
    {
     
        $data = $request->validated();
        $response = $this->userService->store($data);
        if (!$response) {
            return redirect()->back()->with('error', __('errors.user_create_failed'));
        }
        return redirect()->route('admin.users.index')->with('success', __('errors.created'));
    }

    // فرم ویرایش کاربر
    public function edit(User $user)
    {

        return view('admin.pages.users.edit', compact(['user']));
    }

    // بروزرسانی کاربر
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $user = $this->userService->update($data, $user);
        if (!$user) {
            return redirect()->back()->with('error', __('errors.user_update_failed'));
        }

        return redirect()->route('admin.users.index')->with('success', __('errors.updated'));
    }

    // حذف کاربر
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.pages.users.index')->with('success', __('errors.deleted'));
    }
}

@extends('admin.layout.master')

@section('admin-title')
@lang('general.Arya Gostaran Management Panel')
@endsection

@section('admin-content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
    <!-- header page -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">مدیریت نقش‌های کاربری</h2>
            <p class="text-gray-600 dark:text-gray-400">لیست تمام نقش‌های تعریف شده در سیستم</p>
        </div>
        <div class="mt-4 md:mt-0">
            <button id="toggleRoleFormBtn"
                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-primary-600 text-white hover:bg-primary-500 shadow-sm dark:bg-primary-500 dark:hover:bg-primary-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 me-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                نقش جدید
            </button>
        </div>
    </div>
    <!-- Role Form (Create / Edit) -->
    <div id="roleFormWrapper" class="hidden bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6 border">
        <h3 id="roleFormTitle" class="text-lg font-bold mb-4">ایجاد نقش جدید</h3>
        <form id="roleForm" method="POST" action="{{ route('admin.roles.store') }}">
            @csrf
            <input type="hidden" name="_method" id="roleFormMethod" value="POST">
            <input type="hidden" id="roleId">

            {{-- Role Name --}}
            <div class="mb-4">
                <label class="block mb-1">نام نقش</label>
                <input name="name" id="roleName" class="w-full rounded-lg border p-2">
            </div>

            {{-- Permissions --}}
            <div class="mb-4">
                <label class="block mb-1">سطح دسترسی (Permissions)</label>
                <div id="rolePermissionsWrapper" class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach ($permissions as $permission)
                    <label class="flex items-center space-x-2 rtl:space-x-reverse">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                            class="role-permission-checkbox h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <span class="text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>


            <div class="flex justify-end gap-2">
                <button type="button" id="cancelRoleForm" class="px-4 py-2 bg-gray-700 text-white rounded-lg">لغو</button>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg">ذخیره</button>
            </div>
        </form>
    </div>
    @if(session('success'))
    <x-alert type="success" message="{{ session('success') }}"></x-alert>
    @elseif (session('error'))
    <x-alert type="error" message="{{ session('error') }}"></x-alert>
    @endif
    <!-- Roles list -->
    <div class="bg-white py-6 space-y-4 dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-700 overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="px-6 border-b border-gray-200 flex-wrap pb-2 dark:border-gray-700 flex items-center justify-between">
            <h3 class="font-bold text-lg mb-4 relative pb-4 before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">
                لیست نقش‌ها
            </h3>
            <div class="flex items-center space-x-4 space-x-reverse">
                <div class="relative">
                    <input type="text" placeholder="جستجو نقش..." class="ps-10 pe-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute end-3 top-2.5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Roles table -->
        <div class="overflow-x-auto">
            <table class="w-full text-start">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">نام نقش</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">شناسه</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">تعداد کاربران</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">سطح دسترسی</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">عملیات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @foreach ($roles as $key => $role)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $key+1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="ms-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $role->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $role->guard_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $role->admins_count ?? 0 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($role->permissions->count() >= 9)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">کامل</span>
                            @elseif ($role->permissions->count() >= 5)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">متوسط</span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">محدود</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                {{-- Edit Button --}}
                                <button class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 me-4 edit-role-btn"
                                    data-id="{{ $role->id }}"
                                    data-name="{{ $role->name }}"
                                    data-permissions='@json($role->permissions->pluck("id"))'
                                    data-update-url="{{ route('admin.roles.update', $role) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>

                                {{-- Delete Form --}}
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-secondary-600 hover:text-secondary-900 dark:text-secondary-50 dark:hover:text-secondary-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white dark:bg-gray-800 px-6 pt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        نمایش {{ $roles->firstItem() }} تا {{ $roles->lastItem() }} از {{ $roles->total() }} نقش
                    </p>
                </div>
                <div class="flex flex-wrap space-x-2">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/plugin/jquery/jquery1.min.js') }}"></script>
<script src="{{ asset('assets/js/dependencies/app.js') }}"></script>
<script src="{{ asset('assets/js/plugin/jquery/select2.js') }}"></script>

<script>
    const wrapper = $('#roleFormWrapper');

    $('#toggleRoleFormBtn').on('click', function() {
        resetRoleForm();
        wrapper.toggleClass('hidden');
    });

    $('#cancelRoleForm').on('click', function() {
        resetRoleForm();
        wrapper.addClass('hidden');
    });

    $('.edit-role-btn').on('click', function() {
        const url = $(this).data('update-url');
        const permissions = $(this).data('permissions'); // این آرایه id هاست

        wrapper.removeClass('hidden');
        $('#roleFormTitle').text('ویرایش نقش');
        $('#roleName').val($(this).data('name'));
        $('#roleForm').attr('action', url);
        $('#roleFormMethod').val('PUT');

        // ابتدا همه چک‌باکس‌ها رو بردار
        $('.role-permission-checkbox').prop('checked', false);

        // سپس اونایی که از قبل انتخاب شده بودن رو تیک بزن
        permissions.forEach(function(id) {
            $('.role-permission-checkbox[value="' + id + '"]').prop('checked', true);
        });
    });

    function resetRoleForm() {
        $('#roleFormTitle').text('ایجاد نقش جدید');
        $('#roleForm').attr('action', "{{ route('admin.roles.store') }}");
        $('#roleFormMethod').val('POST');
        $('#roleName').val('');
        $('.role-permission-checkbox').prop('checked', false);
    }
</script>
@endpush
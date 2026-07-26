<!-- Sidebar -->
<div class="lg:col-span-1">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-700 p-4 border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{$admin->fullName}} #{{ $admin->id }}</h3>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.admins.edit',$admin) }}" class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700
                  {{ request()->routeIs('admin.admins.edit') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    <span class="ml-2">@lang('general.edit_admin_info')</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.security.index',$admin) }}" class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700
                  {{ request()->routeIs('admin.security.index') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    <span class="ml-2">@lang('general.security')</span>
                </a>
            </li>
            <li>
                <a href="#"
                   class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="ml-2">@lang('general.wallets')</span>
                </a>
            </li>

            <li>
                <a href="#"
                   class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="ml-2">@lang('general.assets')</span>
                </a>
            </li>

            <li>
                <a href="#"
                   class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="ml-2">@lang('general.package')</span>
                </a>
            </li>
            <li>
                <a href="#"
                   class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="ml-2">@lang('general.transactions')</span>
                </a>
            </li>
            <li>
                <a href="#"
                   class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="ml-2">@lang('general.tickets')</span>
                </a>
            </li>
            <li>
                <a href="#"
                   class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="ml-2">@lang('general.cards')</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300  hover:bg-gray-100 dark:hover:bg-gray-700
              {{ request()->routeIs('admin.admin.authentication') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    <span class="ml-2">@lang('general.authentication')</span>
                </a>
            </li>

        </ul>
    </div>
</div>

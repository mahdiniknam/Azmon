@extends('admin.layout.master')

@section('admin-title')
    @lang('general.Arya Gostaran Management Panel') / @lang('general.edit_user')
@endsection
@section('admin-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
        <!-- header page -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">@lang('general.user_general_info_form')</h2>
            </div>
            <div class="mt-4 md:mt-0">
                <button onclick="window.history.back()"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-sm dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 me-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    @lang('general.return')
                </button>
            </div>
        </div>

        <!-- grid layout: sidebar + main content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Main form -->
            <div class="lg:col-span-3 space-y-6">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-700 p-6 border border-gray-200 dark:border-gray-700">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST"
                        class="bg-white py-6 space-y-4 dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-700 overflow-hidden border border-gray-200 dark:border-gray-700">
                        @csrf

                        <div class="px-6 border-b border-gray-200 dark:border-gray-700">
                            <h3
                                class="font-bold text-lg mb-4 relative pb-4 before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">
                                @lang('general.user_info_form')
                            </h3>
                        </div>

                        <div class="px-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Info -->
                            <div class="space-y-4">
                                <div>
                                    <label for="name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        @lang('general.name')
                                    </label>
                                    <input name="name" type="text" id="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('name') is-invalid @enderror">
                                    @error('name')
                                        <x-alert type="error" message="{{ $message }}"></x-alert>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        @lang('general.email_address')
                                    </label>
                                    <input name="email" type="email" id="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('email') is-invalid @enderror">
                                    @error('email')
                                        <x-alert type="error" message="{{ $message }}"></x-alert>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        @lang('general.phone_number')
                                    </label>
                                    <input name="phone" type="tel" id="phone"
                                        value="{{ old('phone', $user->phone) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('phone') is-invalid @enderror">
                                    @error('phone')
                                        <x-alert type="error" message="{{ $message }}"></x-alert>
                                    @enderror
                                </div>

                                <div>
                                    <label for="role"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        @lang('general.role')
                                    </label>
                                    <select name="role" id="role"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('role') is-invalid @enderror">
                                        <option value="">انتخاب نقش</option>
                                        <option value="student" @selected(old('role', $user->role) === 'student')>دانش آموز</option>
                                        <option value="teacher" @selected(old('role', $user->role) === 'teacher')>استاد</option>
                                    </select>
                                    @error('role')
                                        <x-alert type="error" message="{{ $message }}"></x-alert>
                                    @enderror
                                </div>

                            </div>

                            <!-- Account Info -->
                            <div class="space-y-4">
                                <div>
                                    <label for="password"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        @lang('general.password')
                                    </label>
                                    <input name="password" type="password" id="password"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('password') is-invalid @enderror">
                                    @error('password')
                                        <x-alert type="error" message="{{ $message }}"></x-alert>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        @lang('general.confirm_password')
                                    </label>
                                    <input name="password_confirmation" type="password" id="password_confirmation"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        @lang('general.account_status')
                                    </label>

                                    <div class="flex items-center space-x-4 @error('is_active') is-invalid @enderror">
                                        <div class="flex items-center">
                                            <input value="1" id="active" name="is_active" type="radio"
                                                @checked(old('is_active', (string) $user->is_active) === '1')
                                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="active"
                                                class="ms-2 block text-sm text-gray-700 dark:text-gray-300">
                                                @lang('general.active')
                                            </label>
                                        </div>

                                        <div class="flex items-center">
                                            <input value="0" id="inactive" name="is_active" type="radio"
                                                @checked(old('is_active', (string) $user->is_active) === '0')
                                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="inactive"
                                                class="ms-2 block text-sm text-gray-700 dark:text-gray-300">
                                                @lang('general.disabled')
                                            </label>
                                        </div>
                                    </div>

                                    @error('is_active')
                                        <x-alert type="error" message="{{ $message }}"></x-alert>
                                    @enderror
                                </div>


                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-4">
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium rounded-lg bg-primary-600 text-white hover:bg-primary-500 shadow-sm dark:bg-primary-500 dark:hover:bg-primary-600">
                                @lang('general.save_user')
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            @include('admin.pages.users.side')

        </div>
    </main>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/dependencies/app.js') }}"></script>
@endpush

<?php

namespace App\Http\Controllers\Teacher\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class TeacherAuthController extends Controller
{
    public function __construct() {}

    public function showLogin(): View
    {
        if (request()->has('reset_challenge')) {
            Session::forget('teacher_login_challenge');
        }

        $loginChallenge = Session::get('teacher_login_challenge');
        return view('teacher.pages.Auth.login', compact('loginChallenge'));
    }

    public function login(Request $request): RedirectResponse
    {
        $this->normalizeRegistrationData($request);
        Auth::guard('web')->logout();

        $credentials = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'remember' => ['nullable', 'boolean'],
        ]);

        $remember = (bool) ($credentials['remember'] ?? false);
        unset($credentials['remember']);
        $credentials['role'] = 'teacher';
        $credentials['is_active'] = true;

        if (! Auth::guard('web')->attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => 'ایمیل یا رمز عبور واردشده صحیح نیست.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('teacher.exams.index'));
    }

    public function showRegister(): View
    {
        return view('teacher.pages.Auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $this->normalizeRegistrationData($request);
        Auth::guard('admin')->logout();

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                'max:72',
                Password::min(8)->letters()->numbers(),
            ],
        ]);

        $teacher = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
            'is_active' => true,
        ]);

        Auth::guard('web')->login($teacher);
        $request->session()->regenerate();

        return redirect()
            ->route('teacher.exams.index')
            ->with('status', 'حساب کاربری استاد با موفقیت ساخته شد.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('teacher.login')
            ->with('status', 'با موفقیت از حساب کاربری خارج شدید.');
    }

    private function normalizeRegistrationData(Request $request): void
    {
        $request->merge([
            'name' => trim((string) $request->input('name')),
            'email' => strtolower(trim((string) $request->input('email'))),
        ]);
    }
}

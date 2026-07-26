<?php

namespace App\Http\Controllers\Student\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CaptchaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class StudentAuthController extends Controller
{
    public function __construct() {}
    public function showLogin(): View
    {
        if (request()->has('reset_challenge')) {
            Session::forget('student_login_challenge');
        }


        $loginChallenge = Session::get('student_login_challenge'); // ممکنه null باشه
        return view('student.pages.Auth.login', compact('loginChallenge'));
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
        $credentials['role'] = 'student';
        $credentials['is_active'] = true;

        if (! Auth::guard('web')->attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => 'ایمیل یا رمز عبور واردشده صحیح نیست.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('student.exams.index'));
    }

    public function showRegister(): View
    {
        return view('student.pages.Auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $this->normalizeRegistrationData($request);
        Auth::guard('web')->logout();

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

        $student = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
            'is_active' => true,
        ]);

        Auth::guard('web')->login($student);
        $request->session()->regenerate();

        return redirect()
            ->route('student.exams.index')
            ->with('status', 'حساب دانش‌آموزی شما با موفقیت ساخته شد.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('student.login')
            ->with('status', 'با موفقیت از حساب دانش‌آموزی خارج شدید.');
    }

    private function normalizeRegistrationData(Request $request): void
    {
        $request->merge([
            'name' => trim((string) $request->input('name')),
            'email' => strtolower(trim((string) $request->input('email'))),
        ]);
    }
}

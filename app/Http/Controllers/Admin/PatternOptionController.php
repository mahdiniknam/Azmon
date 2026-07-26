<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PatternOption;

class PatternOptionController extends Controller
{

    // ------------------ مشترک ------------------
    private function patternsEdit(int $type, string $section)
    {
        $locale = app()->getLocale();

        // فقط کلیدهایی که توی config تعریف کردیم باید قابل نمایش باشند
        $configPatterns = config("patterns." . ($type === PatternOption::TYPE_SMS ? 'sms' : 'email') . ".$section") ?? [];
        $keys = collect($configPatterns)->pluck('key')->toArray();

        $patterns = PatternOption::query()
            ->where('type', $type)
            ->where('locale', $locale)
            ->whereIn('key', $keys)
            ->orderBy('id', 'asc')
            ->get();

        $title = ($type === PatternOption::TYPE_SMS)
            ? ($section === 'admin' ? __('general.sms_patterns_admin') : __('general.sms_patterns_user'))
            : ($section === 'admin' ? __('general.email_patterns_admin') : __('general.email_patterns_user'));

        return view('admin.pages.setting.patterns.edit', compact('patterns', 'type', 'section', 'title'));
    }

    private function patternsUpdate(Request $request, int $type)
    {
        $locale = app()->getLocale();

        $validated = $request->validate([
            'section' => ['required', 'in:user,admin'],
            'values' => ['required', 'array'],
            'values.*' => ['nullable', 'string', 'max:2000'],
        ]);

        $section = $validated['section'];

        $configPatterns = config("patterns." . ($type === PatternOption::TYPE_SMS ? 'sms' : 'email') . ".$section") ?? [];
        $allowedKeys = collect($configPatterns)->pluck('key')->toArray();

        foreach ($validated['values'] as $key => $value) {
            if (!in_array($key, $allowedKeys, true)) continue;

            PatternOption::query()->updateOrCreate(
                [
                    'key' => $key,
                    'type' => $type,
                    'locale' => $locale,
                ],
                [
                    'value' => $value,
                ]
            );
        }

        return back()->with('success', __('general.saved_successfully'));
    }

        // ------------------ EMAIL PATTERNS ------------------
    public function emailpatternsUser()
    {
        return $this->patternsEdit(type: PatternOption::TYPE_EMAIL, section: 'user');
    }

    public function emailpatternsAdmin()
    {
        return $this->patternsEdit(type: PatternOption::TYPE_EMAIL, section: 'admin');
    }

    public function emailpatternsUpdate(Request $request)
    {
        return $this->patternsUpdate($request, PatternOption::TYPE_EMAIL);
    }
        // ------------------ SMS PATTERNS ------------------
    public function smspatternsUser()
    {
        return $this->patternsEdit(type: PatternOption::TYPE_SMS, section: 'user');
    }

    public function smspatternsAdmin()
    {
        return $this->patternsEdit(type: PatternOption::TYPE_SMS, section: 'admin');
    }

    public function smspatternsUpdate(Request $request)
    {
        return $this->patternsUpdate($request, PatternOption::TYPE_SMS);
    }
}

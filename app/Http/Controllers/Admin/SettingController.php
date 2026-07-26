<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function __construct(private SettingService $settings)
    {}

    public function index()
    {
        $settings = [
            [
                'id'    => 1,
                'title' => __('general.site_setting'),
                'route' => route('admin.setting.site.edit'),
            ],
            [
                'id'    => 2,
                'title' => __('general.sms_setting'),
                'route' => route('admin.setting.sms.index'),
            ],
            [
                'id'    => 3,
                'title' => __('general.email_setting'),
                'route' => route('admin.setting.email.index'),
            ],
            [
                'id'    => 4,
                'title' => __('general.gateways_setting'),
                'route' => route('admin.setting.gateways.index'),
            ],
            [
                'id'    => 5,
                'title' => 'تنظیمات ربات بله',
                'route' => route('admin.setting.bale.edit'),
            ],
        ];

        return view('admin.pages.setting.index', [
            'settings' => $settings,
        ]);
        // return view('admin.pages.setting.index');
    }

    //setting sms
    public function smsIndex()
    {
        $smsSettings = [
            [
                'id'    => 1,
                'title' => __('general.sms_provider'),
                'route' => route('admin.setting.sms.edit'),
            ],
            [
                'id'    => 2,
                'title' => __('general.sms_patterns_user'),
                'route' => route('admin.setting.sms.patterns.user'),
            ],
            [
                'id'    => 3,
                'title' => __('general.sms_patterns_admin'),
                'route' => route('admin.setting.sms.patterns.admin'),
            ],
        ];

        return view('admin.pages.setting.sms.index', compact('smsSettings'));
    }
    public function smsSettingEdit()
    {
        $providers = $this->smsProviders();

        $activeProvider = $this->settings->get('sms.provider.active', 'melipayamak');
        if (! array_key_exists($activeProvider, $providers)) {
            $activeProvider = array_key_first($providers) ?? 'melipayamak';
        }
        // مقداردهی اولیه فیلدها برای همه providerها تا ویو بتونه هر کدوم رو نمایش بده
        $values = [];
        foreach ($providers as $providerKey => $provider) {
            foreach ($provider['fields'] as $fieldKey => $meta) {
                $values[$providerKey][$fieldKey] = $this->settings->get("sms.providers.$providerKey.$fieldKey", '');
            }
        }
        return view('admin.pages.setting.sms.edit', compact('providers', 'activeProvider', 'values'));
    }
    /**
     * تعریف Providerها + فیلدهای هر Provider
     * با اضافه کردن provider جدید اینجا، ویو خودش آپدیت میشه.
     */
    private function smsProviders(): array
    {
        return [
            'melipayamak' => [
                'title'  => __('general.melipayamak'),
                'fields' => [
                    'username' => ['label' => __('general.sms_username'), 'type' => 'text', 'required' => true],
                    'password' => ['label' => __('general.sms_password'), 'type' => 'password', 'required' => true],
                ],
            ],
            'limoHost'    => [
                'title'  => __('general.limo_host'),
                'fields' => [
                    'api_key' => ['label' => __('general.sms_api_key'), 'type' => 'text', 'required' => true],
                    'sender'  => ['label' => __('general.sms_sender'), 'type' => 'text', 'required' => false],
                ],
            ],
        ];
    }
    public function smsUpdate(Request $request)
    {
        $providers   = $this->smsProviders();
        $providerKey = $request->input('sms_provider');
        if (! array_key_exists($providerKey, $providers)) {
            return back()->with('error', __('errors.invalid_sms_provider'));
        }
        // اعتبارسنجی بر اساس فیلدهای همان provider انتخابی
        $rules = [
            'sms_provider' => ['required', 'string'],
        ];

        foreach ($providers[$providerKey]['fields'] as $fieldKey => $meta) {
            $rule                      = [];
            $rule[]                    = ($meta['required'] ?? false) ? 'required' : 'nullable';
            $rule[]                    = 'string';
            $rule[]                    = 'max:500';
            $rules["fields.$fieldKey"] = $rule;
        }

        $validated = $request->validate($rules);
        // ذخیره provider فعال
        $this->settings->set('sms.provider.active', $providerKey);

        // ذخیره فیلدهای همان provider
        $fields = $validated['fields'] ?? [];
        foreach ($providers[$providerKey]['fields'] as $fieldKey => $meta) {
            $this->settings->set("sms.providers.$providerKey.$fieldKey", $fields[$fieldKey] ?? null);
        }
        Cache::flush();
        return back()->with('success', __('general.saved_successfully'));
    }
    //email setting
    public function emailIndex()
    {
        $emailSettings = [
            [
                'id'    => 1,
                'title' => __('general.email_provider'),
                'route' => route('admin.setting.email.edit'),
            ],
            [
                'id'    => 2,
                'title' => __('general.email_patterns_user'),
                'route' => route('admin.setting.email.patterns.user'),
            ],
            [
                'id'    => 3,
                'title' => __('general.email_patterns_admin'),
                'route' => route('admin.setting.email.patterns.admin'),
            ],
        ];

        return view('admin.pages.setting.email.index', compact('emailSettings'));
    }

    /**
     * تعریف Providerها + فیلدهای هر Provider
     * با اضافه کردن provider جدید اینجا، ویو خودش آپدیت میشه.
     */
    private function emailProviders(): array
    {
        return [
            'smtp' => [
                'title'  => __('general.smtp'),
                'fields' => [
                    'host'         => ['label' => __('general.email_host'), 'type' => 'text', 'required' => true],
                    'port'         => ['label' => __('general.email_port'), 'type' => 'text', 'required' => true],
                    'username'     => ['label' => __('general.email_username'), 'type' => 'text', 'required' => true],
                    'password'     => ['label' => __('general.email_password'), 'type' => 'password', 'required' => true],
                    'encryption'   => ['label' => __('general.email_encryption'), 'type' => 'text', 'required' => false], // tls/ssl
                    'from_address' => ['label' => __('general.email_from_address'), 'type' => 'text', 'required' => true],
                    'from_name'    => ['label' => __('general.email_from_name'), 'type' => 'text', 'required' => false],
                ],
            ],

            // اگر بعداً خواستی mailgun / sendgrid اضافه کنی همینجا
            // 'mailgun' => [...]
        ];
    }

    public function emailSettingEdit()
    {
        $providers = $this->emailProviders();

        $activeProvider = $this->settings->get('email.provider.active', 'smtp');
        if (! array_key_exists($activeProvider, $providers)) {
            $activeProvider = array_key_first($providers) ?? 'smtp';
        }

        $values = [];
        foreach ($providers as $providerKey => $provider) {
            foreach ($provider['fields'] as $fieldKey => $meta) {
                $values[$providerKey][$fieldKey] = $this->settings->get("email.providers.$providerKey.$fieldKey", '');
            }
        }

        return view('admin.pages.setting.email.edit', compact('providers', 'activeProvider', 'values'));
    }

    public function emailUpdate(Request $request)
    {
        $providers   = $this->emailProviders();
        $providerKey = $request->input('email_provider');

        if (! array_key_exists($providerKey, $providers)) {
            return back()->with('error', __('errors.invalid_email_provider'));
        }

        $rules = [
            'email_provider' => ['required', 'string'],
        ];

        foreach ($providers[$providerKey]['fields'] as $fieldKey => $meta) {
            $rule                      = [];
            $rule[]                    = ($meta['required'] ?? false) ? 'required' : 'nullable';
            $rule[]                    = 'string';
            $rule[]                    = 'max:500';
            $rules["fields.$fieldKey"] = $rule;
        }

        $validated = $request->validate($rules);

        // ذخیره provider فعال
        $this->settings->set('email.provider.active', $providerKey);

        // ذخیره فیلدهای همان provider
        $fields = $validated['fields'] ?? [];
        foreach ($providers[$providerKey]['fields'] as $fieldKey => $meta) {
            $this->settings->set("email.providers.$providerKey.$fieldKey", $fields[$fieldKey] ?? null);
        }
        Cache::flush();

        return back()->with('success', __('general.saved_successfully'));
    }
    public function siteKey(): array
    {
        return [
            'site_name',
            'site_logo',
            'site_email',
            'site_favicon',
            'site_author',
            'terms_pdf',
            'site_copy_right',
            'site_icon',
            'site_login_picture',
            'site_des',
        ];
    }

    public function siteEdit(SettingService $settingService)
    {
        $keys = $this->siteKey();

        // همه تنظیمات رو بگیر و به ویو بده
        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = $settingService->get($key);
        }
        return view('admin.pages.setting.site.index', compact('settings'));
    }

    public function siteUpdate(Request $request, SettingService $settingService)
    {
        $validated = $request->validate([
            'site_name'          => ['nullable', 'string', 'max:255'],
            'site_email'         => ['nullable', 'email', 'max:255'],
            'site_author'        => ['nullable', 'string', 'max:255'],
            'site_copy_right'    => ['nullable', 'string', 'max:255'],
            'site_des'           => ['nullable', 'string', 'max:5000'],

            // فایل‌ها
            'site_logo'          => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'site_favicon'       => ['nullable', 'file', 'mimes:ico,png,svg', 'max:1024'],
            'site_icon'          => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'site_login_picture' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'terms_pdf'          => ['nullable', 'file', 'mimes:pdf,docx', 'max:5120'],
        ]);

        // فیلدهای متنی
        $textItems = collect($validated)
            ->only(['site_name', 'site_email', 'site_author', 'site_copy_right', 'site_des'])
            ->toArray();

        // فیلدهای فایل
        $fileKeys = ['site_logo', 'site_favicon', 'site_icon', 'site_login_picture', 'terms_pdf'];

        foreach ($fileKeys as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);

                                                            // مسیر ذخیره
                $path = $file->store('settings', 'public'); // storage/app/public/settings/...

                // اگر قبلاً فایل داشتیم، حذفش کنیم (اختیاری ولی تمیز)
                $old = $settingService->get($fileKey);
                if ($old && is_string($old)) {
                    // اگر قبلاً Storage::url ذخیره کرده باشی، url برمی‌گرده (/storage/...)
                    // اینجا سعی می‌کنیم به path تبدیل کنیم
                    $oldPath = str_replace('/storage/', '', $old);
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }

                // مقدار ذخیره شده داخل setting: URL فایل
                $textItems[$fileKey] = Storage::url($path);
            }
        }

        //  dd($textItems);
        // ذخیره همه با هم
        $settingService->setMany($textItems, '*');

        return back()->with('success', __('general.Settings updated successfully'));
    }

    public function baleEdit()
    {
        // Using existing config/database settings logic (simplified)
        $botToken = \App\Models\Setting::getValue('bale.bot_token', config('services.bale.bot_token'));
        $reportChatId = \App\Models\Setting::getValue('bale.report_chat_id', config('services.bale.report_chat_id'));
        $enabled = \App\Models\Setting::getValue('bale.enabled', config('services.bale.enabled', false));

        return view('admin.pages.setting.bale-bot', compact('botToken', 'reportChatId', 'enabled'));
    }

    public function baleUpdate(Request $request)
    {
        $request->validate([
            'bot_token' => 'nullable|string',
            'report_chat_id' => 'nullable|string',
        ]);

        \App\Models\Setting::setValue('bale.bot_token', $request->bot_token);
        \App\Models\Setting::setValue('bale.report_chat_id', $request->report_chat_id);
        \App\Models\Setting::setValue('bale.enabled', $request->has('enabled') ? '1' : '0');

        return redirect()->back()->with('success', 'تنظیمات ربات بله با موفقیت ذخیره شد.');
    }
}

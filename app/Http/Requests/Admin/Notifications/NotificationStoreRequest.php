<?php
namespace App\Http\Requests\Admin\Notifications;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class NotificationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // اگر policy داری اینجا اعمال کن
    }

    public function rules(): array
    {
        return [
            'user_ids'       => ['required', 'array', 'min:1'],
            'user_ids.*'     => ['integer', 'exists:users,id'],

            'channels'       => ['required', 'array', 'min:1'],
            'channels.*'     => ['in:internal,email,sms'],

            'title'          => ['required', 'array'],
            'title.fa'       => ['required', 'string', 'max:255'],

            'description'    => ['required', 'array'],
            'description.fa' => ['required', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'user_ids.required' => __('general.select_at_least_one_user'),
            'user_ids.min'      => __('general.select_at_least_one_user'),
        ];
    }
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $v) {
            $channels = (array) $this->input('channels', []);

            // اگر internal انتخاب شده، حداقل title.fa یا description.fa باید پر باشد
            if (in_array('internal', $channels, true)) {
                $titleFa = trim((string) $this->input('title.fa', ''));
                $descFa  = trim((string) $this->input('description.fa', ''));

                if ($titleFa === '' && $descFa === '') {
                    $v->errors()->add('title.fa', __('errors.internal_requires_text'));
                }
            }
        });
    }
}

<?php

namespace App\Http\Requests\Admin\Notifications;

use Illuminate\Foundation\Http\FormRequest;

class NotificationIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * type: internal | email | sms
     * read: 0/1
     * range: 7days | 1month
     */
    public function rules(): array
    {
        return [
            'type' => ['nullable', 'in:internal,email,sms'],
            'read' => ['nullable', 'boolean'],
            'range' => ['nullable', 'in:7days,1month'],
        ];
    }
}

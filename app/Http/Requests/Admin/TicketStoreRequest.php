<?php

namespace App\Http\Requests\Admin;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;

class TicketStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // وقتی ادمین می‌سازه باید user انتخاب بشه
            'user_id' => ['required', 'exists:users,id'],

            'department_id' => ['required', 'exists:departments,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],

            'priority' => ['nullable', 'integer', 'in:' . implode(',', [
                Ticket::PRIORITY_LOW,
                Ticket::PRIORITY_MEDIUM,
                Ticket::PRIORITY_HIGH,
            ])],

            'files' => ['nullable', 'array'],
            'files.*' => ['file', 'max:10240'],
        ];
    }
}

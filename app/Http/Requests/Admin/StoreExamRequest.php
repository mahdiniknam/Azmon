<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'in:single,multi'],
            'duration' => ['required', 'integer', 'min:10'],

            // اگر ورودی شمسی است، دیگر rule=date نگذار
            'start_date' => ['required', 'string'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_date' => ['required', 'string'],
            'end_time' => ['required', 'date_format:H:i'],

            'negative_score' => ['nullable', 'numeric', 'min:0'],
            'shuffle_questions' => ['nullable', 'boolean'],
            'shuffle_options' => ['nullable', 'boolean'],

            'is_public' => ['required', 'in:1,0'],

            'price' => ['nullable', 'numeric', 'min:0'],
            'payment_type' => ['nullable', 'in:student,creator'],
            'max_participants' => ['nullable', 'integer', 'min:1'],

            'students' => ['nullable', 'array'],
            'students.*' => ['exists:users,id'],

            'subjects' => ['nullable', 'array'],
            'subjects.*.question_count' => ['nullable', 'integer', 'min:1'],
            'subjects.*.negative_score' => ['nullable', 'numeric', 'min:0'],
            'subjects.*.order' => ['nullable', 'integer', 'min:0'],

            'questions' => ['nullable', 'array'],
            'questions.*' => ['exists:questions,id'],

            'teacher_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'teacher'),
            ],
        ];
    }


    public function messages(): array
    {
        return [
            'title.required' => 'عنوان آزمون الزامی است.',
            'title.max' => 'عنوان آزمون نباید بیشتر از 255 کاراکتر باشد.',

            'description.string' => 'توضیحات آزمون نامعتبر است.',

            'type.required' => 'نوع آزمون الزامی است.',
            'type.max' => 'نوع آزمون نامعتبر است.',

            'access_type.required' => 'نوع دسترسی آزمون الزامی است.',
            'access_type.in' => 'نوع دسترسی آزمون باید عمومی یا خصوصی باشد.',

            'duration.required' => 'مدت آزمون الزامی است.',
            'duration.integer' => 'مدت آزمون باید عدد صحیح باشد.',
            'duration.min' => 'مدت آزمون باید حداقل 10 دقیقه باشد.',

            'start_date.required' => 'تاریخ شروع آزمون الزامی است.',
            'start_date.date' => 'تاریخ شروع آزمون نامعتبر است.',

            'start_time.required' => 'ساعت شروع آزمون الزامی است.',
            'start_time.date_format' => 'فرمت ساعت شروع باید به صورت HH:MM باشد.',

            'end_date.required' => 'تاریخ پایان آزمون الزامی است.',
            'end_date.date' => 'تاریخ پایان آزمون نامعتبر است.',

            'end_time.required' => 'ساعت پایان آزمون الزامی است.',
            'end_time.date_format' => 'فرمت ساعت پایان باید به صورت HH:MM باشد.',

            'negative_score.numeric' => 'نمره منفی باید عددی باشد.',
            'negative_score.min' => 'نمره منفی نمی‌تواند کمتر از صفر باشد.',

            'shuffle_questions.boolean' => 'مقدار درهم‌سازی سوالات نامعتبر است.',
            'shuffle_options.boolean' => 'مقدار درهم‌سازی گزینه‌ها نامعتبر است.',

            'price.numeric' => 'هزینه آزمون باید عددی باشد.',
            'price.min' => 'هزینه آزمون نمی‌تواند کمتر از صفر باشد.',

            'payment_type.in' => 'نوع پرداخت باید student یا teacher باشد.',

            'max_participants.integer' => 'حداکثر شرکت‌کنندگان باید عدد صحیح باشد.',
            'max_participants.min' => 'حداکثر شرکت‌کنندگان باید حداقل 1 باشد.',

            'allowed_students.array' => 'لیست دانشجویان مجاز نامعتبر است.',
            'allowed_students.*.exists' => 'یکی از دانشجویان انتخاب‌شده معتبر نیست.',

            'subjects.array' => 'ساختار دروس نامعتبر است.',
            'subjects.*.question_count.integer' => 'تعداد سوالات هر درس باید عدد صحیح باشد.',
            'subjects.*.question_count.min' => 'تعداد سوالات هر درس باید حداقل 1 باشد.',
            'subjects.*.negative_score.numeric' => 'نمره منفی هر درس باید عددی باشد.',
            'subjects.*.negative_score.min' => 'نمره منفی هر درس نمی‌تواند کمتر از صفر باشد.',
            'subjects.*.order.integer' => 'ترتیب هر درس باید عدد صحیح باشد.',
            'subjects.*.order.min' => 'ترتیب هر درس نمی‌تواند کمتر از صفر باشد.',

            'questions.array' => 'ساختار سوالات نامعتبر است.',
            'questions.*.exists' => 'یکی از سوالات انتخاب‌شده معتبر نیست.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $startDate = $this->input('start_date');
            $startTime = $this->input('start_time');
            $endDate = $this->input('end_date');
            $endTime = $this->input('end_time');

            if ($startDate && $startTime && $endDate && $endTime) {
                $start = strtotime($startDate . ' ' . $startTime);
                $end = strtotime($endDate . ' ' . $endTime);

                if ($end <= $start) {
                    $validator->errors()->add('end_time', 'زمان پایان آزمون باید بعد از زمان شروع آزمون باشد.');
                }
            }

            if ($this->input('access_type') === 'private' && empty($this->input('allowed_students'))) {
                $validator->errors()->add('allowed_students', 'برای آزمون خصوصی باید حداقل یک دانشجو انتخاب شود.');
            }

            if ($this->filled('price') && !$this->filled('payment_type')) {
                $validator->errors()->add('payment_type', 'وقتی برای آزمون هزینه تعیین می‌شود، نوع پرداخت نیز الزامی است.');
            }

            if (is_array($this->input('subjects'))) {
                foreach (array_keys($this->input('subjects')) as $subjectId) {
                    if (!is_numeric($subjectId) || !\App\Models\Subject::whereKey($subjectId)->exists()) {
                        $validator->errors()->add('subjects', 'یکی از دروس انتخاب‌شده معتبر نیست.');
                        break;
                    }
                }
            }
        });
    }
}

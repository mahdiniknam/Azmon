<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PeriodStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "months" => [
                "required",
                "integer",
                "between:1,12",
                Rule::unique('periods', 'months')
                    ->where(fn ($query) =>
                        $query->where('product_id', $this->product_id)
                    ),
            ],

            "product_id" => [
                "required",
                "exists:products,id"
            ],

            "discount_type" => [
                "required",
                "in:percentage,fixed"
            ],

            "discount_value" => [
                "required",
                "numeric",
                "min:0"
            ],

            "is_active" => [
                "required",
                "boolean"
            ],
        ];
    }
    public function messages(): array
    {
        return [
            "product_id.required" => "شناسه محصول الزامی است.",
            "product_id.exists" => "محصول انتخاب شده معتبر نیست.",

            "months.required" => "ماه الزامی است.",
            "months.integer" => "ماه باید عدد باشد.",
            "months.between" => "ماه باید عددی بین 1 تا 12 باشد.",
            "months.unique" => "برای این محصول این ماه قبلاً ثبت شده است.",

            "discount_type.required" => "نوع تخفیف الزامی است.",
            "discount_type.in" => "نوع تخفیف باید percent یا fixed باشد.",

            "discount_value.required" => "مقدار تخفیف الزامی است.",
            "discount_value.numeric" => "مقدار تخفیف باید عدد باشد.",
            "discount_value.min" => "مقدار تخفیف نمی‌تواند منفی باشد.",

            "is_active.required" => "وضعیت فعال بودن الزامی است.",
            "is_active.boolean" => "وضعیت فعال بودن باید true یا false باشد.",
        ];
    }
}

<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'slug' => ['required', 'string', 'max:191', 'unique:products,slug'],

            'description' => ['nullable', 'string'],

            'price' => ['required', 'integer', 'min:1'],

            'is_active' => ['required', 'in:1,0'],

            // فایل‌ها
            'main_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gallery_images' => ['nullable', 'array', 'max:10'],
            'gallery_images.*' => ['file', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            // ویژگی‌ها
            'properties' => ['nullable', 'array'],
            'properties.key' => ['nullable', 'array'],
            'properties.key.*' => ['nullable', 'string', 'max:191'],
            'properties.value' => ['nullable', 'array'],
            'properties.value.*' => ['nullable', 'string', 'max:191'],
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'دسته‌بندی',
            'name' => 'نام محصول',
            'slug' => 'اسلاگ',
            'description' => 'توضیحات',
            'capacity' => 'ظرفیت',
            'price' => 'قیمت کل',
            'status' => 'وضعیت',
            'main_image' => 'تصویر اصلی',
            'gallery_images' => 'تصاویر گالری',
            'gallery_images.*' => 'تصویر گالری',
            'properties.key.*' => 'عنوان ویژگی',
            'properties.value.*' => 'مقدار ویژگی',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'انتخاب دسته‌بندی الزامی است.',
            'category_id.exists'   => 'دسته‌بندی انتخاب شده معتبر نیست.',

            'name.required' => 'نام محصول الزامی است.',
            'name.max'      => 'نام محصول نباید بیشتر از ۱۹۱ کاراکتر باشد.',

            'slug.required' => 'اسلاگ الزامی است.',
            'slug.unique'   => 'این اسلاگ قبلاً ثبت شده است.',
            'slug.max'      => 'اسلاگ نباید بیشتر از ۱۹۱ کاراکتر باشد.',

            'capacity.required' => 'ظرفیت الزامی است.',
            'capacity.min'      => 'ظرفیت باید حداقل ۱ باشد.',
            'capacity.integer'  => 'ظرفیت باید عدد باشد.',

            'price.required' => 'قیمت کل الزامی است.',
            'price.integer'  => 'قیمت کل باید عدد باشد.',
            'price.min'      => 'قیمت کل باید بزرگتر از ۰ باشد.',

            'status.required' => 'وضعیت الزامی است.',
            'status.in'       => 'وضعیت انتخاب شده معتبر نیست.',

            'main_image.mimes' => 'فرمت تصویر اصلی فقط jpg, jpeg, png, webp مجاز است.',
            'main_image.max'   => 'حجم تصویر اصلی نباید بیشتر از ۲ مگابایت باشد.',

            'gallery_images.array' => 'فرمت تصاویر گالری معتبر نیست.',
            'gallery_images.max'   => 'حداکثر ۱۰ تصویر گالری مجاز است.',
            'gallery_images.*.mimes' => 'فرمت تصویر گالری فقط jpg, jpeg, png, webp مجاز است.',
            'gallery_images.*.max'   => 'حجم هر تصویر گالری نباید بیشتر از ۲ مگابایت باشد.',
        ];
    }
}

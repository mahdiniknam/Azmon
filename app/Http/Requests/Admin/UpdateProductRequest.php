<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [

            'name' => ['required', 'string', 'max:191'],
            'slug' => ['required', 'string', 'max:191', Rule::unique('products', 'slug')->ignore($productId)],

            'description' => ['nullable', 'string'],

            'price' => ['required','min:1'],

            'is_active' => ['required', 'in:1,0'],

            'main_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gallery_images' => ['nullable', 'array', 'max:10'],
            'gallery_images.*' => ['file', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

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
            'is_active' => 'وضعیت',
            'main_image' => 'تصویر اصلی',
            'gallery_images' => 'تصاویر گالری',
            'gallery_images.*' => 'تصویر گالری',
            'properties.key.*' => 'عنوان ویژگی',
            'properties.value.*' => 'مقدار ویژگی',
        ];
    }

    public function messages(): array
    {
        // همون پیام‌های Store کافی‌اند
        return (new StoreProductRequest())->messages();
    }
}

<?php

namespace App\Traits;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasTranslations
{
    /**
     * رابطه ترجمه‌ها
     */
    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    /**
     * گرفتن ترجمه یک فیلد
     */
    public function t(string $field, ?string $locale = null, mixed $default = null): mixed
    {
        $locale = $locale ?? app()->getLocale();

        return $this->translations
            ->where('field', $field)
            ->where('locale', $locale)
            ->first()
            ?->value ?? $default;
    }

    /**
     * ست کردن ترجمه
     */
    public function setT(string $field, string $locale, mixed $value): void
    {
        $this->translations()->updateOrCreate(
            [
                'field'  => $field,
                'locale' => $locale,
            ],
            [
                'value' => (string) $value,
            ]
        );
    }

    /**
     * گرفتن همه ترجمه‌های یک فیلد
     */
    public function getTranslations(string $field): array
    {
        return $this->translations
            ->where('field', $field)
            ->pluck('value', 'locale')
            ->toArray();
    }

    /**
     * حذف ترجمه‌ها
     */
    public function forgetTranslations(?string $field = null): void
    {
        $query = $this->translations();

        if ($field) {
            $query->where('field', $field);
        }

        $query->delete();
    }
}

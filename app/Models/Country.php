<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    // ۱. مشخص کردن فیلدهایی که اجازه پر شدن انبوه دارند (Mass Assignment)
    protected $fillable = [
        'name', 'iso3', 'numeric_code', 'iso2', 'phonecode', 'capital', 
        'currency', 'currency_name', 'currency_symbol', 'tld', 'native', 
        'region', 'subregion', 'nationality', 'timezones', 'translations', 
        'latitude', 'longitude', 'emoji', 'emojiU'
    ];

    // ۲. تبدیل خودکار فیلدهای JSON یا آرایه (Casting)
    protected $casts = [
        'timezones'    => 'array',
        'translations' => 'array',
        'latitude'     => 'decimal:8',
        'longitude'    => 'decimal:8',
    ];

    /**
     * ۳. رابطه با مدل کاربر (هر کشور می‌تواند کاربران زیادی داشته باشد)
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

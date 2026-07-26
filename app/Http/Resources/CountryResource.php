<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name_en'      => $this->name,
            'name_fa'      => $this->native, // نمایش نام بومی (فارسی)
            'iso'          => $this->iso2,
            'calling_code' => str_replace('+', '', $this->phonecode), // حذف + برای استفاده راحت در API
            'flag'         => $this->emoji,
            'currency'     => [
                'code'   => $this->currency,
                'name'   => $this->currency_name,
                'symbol' => $this->currency_symbol,
            ],
            'location'     => [
                'lat' => (float) $this->latitude,
                'lng' => (float) $this->longitude,
            ],
        ];
    }
}
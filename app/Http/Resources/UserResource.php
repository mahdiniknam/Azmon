<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        // فرمت ثابت پاسخ
        return [
            'id' => $this->id,
            'name' => $this->full_name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}

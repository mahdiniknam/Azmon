<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = [
        'disk',
        'path',
        'original_name',
        'mime_type',
        'size',
        'collection',
        'sort_order',
        'fileable_id',
        'fileable_type',
        'uploaded_by_id',
        'uploaded_by_type',
    ];

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    public function uploadedBy(): MorphTo
    {
        return $this->morphTo();
    }

    public function url(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }
}

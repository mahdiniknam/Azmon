<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class SystemLog extends Model
{
    protected $fillable = [
        'level',
        'message',
        'context',
        'extra',
        'datetime',
        'channel',
        'environment',
    ];
    protected $casts = [
        'context'=> 'array',
        'extra'=> 'array',
        'datetime'=> 'datetime',
    ];

    public function getCreatedAt($format = 'Y/m/d  H:i:s', string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        if ($locale == 'fa') {
            return Jalalian::fromDateTime($this->created_at)->format($format);
        }

        return $this->created_at->format($format);
    }
}

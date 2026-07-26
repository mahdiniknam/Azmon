<?php

namespace App\Models;

use App\Filters\Contracts\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\GetDisplayName;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Morilog\Jalali\Jalalian;

class AdminActivityLog extends Model
{

    use Filterable;

    //
    protected $table = 'admin_activity_logs';
    protected $fillable = ["ip", "admin_id", "model_type", "model_id", "changes", "route"];public function admin(){
        return $this->belongsTo(Admin::class, "admin_id");
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }



    public function getCreatedAt($format = 'Y/m/d  H:i:s', string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        if ($locale == 'fa') {
            return Jalalian::fromDateTime($this->created_at)->format($format);
        }

        return $this->created_at->format($format);
    }


}

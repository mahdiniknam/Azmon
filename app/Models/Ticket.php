<?php

namespace App\Models;

use App\Filters\Contracts\Filterable;
use App\Traits\HasJalaliTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes, Filterable,HasJalaliTimestamps;

    protected $fillable = [
        'user_id',
        'creator_id',
        'creator_type',
        'admin_id',
        'department_id',
        'title',
        'description',
        'status',
        'priority',
        'seen_at',
        'star',
    ];

    protected $appends = ['created_at_jalali', 'updated_at_jalali'];

    public const STATUS_NEW = 'new';
    public const STATUS_PENDING = 'pending';
    public const STATUS_ANSWERED_BY_ADMIN = 'answered_by_admin';
    public const STATUS_ANSWERED_BY_USER = 'answered_by_user';
    public const STATUS_CLOSED = 'closed';

    public const PRIORITY_LOW = 1;
    public const PRIORITY_MEDIUM = 2;
    public const PRIORITY_HIGH = 3;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // سازنده تیکت (Admin یا User)
    public function creator()
    {
        return $this->morphTo();
    }

    // ادمین مسئول
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }
}

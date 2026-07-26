<?php

namespace App\Models;

use App\Traits\HasJalaliTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketMessage extends Model
{
    use SoftDeletes,HasJalaliTimestamps;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'user_type',
        'message',
        'status',
        'seen_at',
        'from',
    ];

    protected $appends = ['created_at_jalali', 'updated_at_jalali'];

    public const STATUS_NOT_SEEN = 'not_seen';
    public const STATUS_SEEN = 'seen';

    public const FROM_ADMIN = 'admin';
    public const FROM_USER = 'user';

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->morphTo();
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}

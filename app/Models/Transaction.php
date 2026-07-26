<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_type', 'user_id', 'amount', 'type', 'tracking_code',
        'exam_id', 'gateway', 'status', 'description',
    ];

    public function user() { return $this->morphTo(); }
    public function exam() { return $this->belongsTo(Exam::class); }
}

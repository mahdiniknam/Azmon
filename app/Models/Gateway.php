<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gateway extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['title', 'driver', 'config', 'is_active'];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
    ];

    // public function payments()
    // {
    //     return $this->hasMany(Payment::class);
    // }
}

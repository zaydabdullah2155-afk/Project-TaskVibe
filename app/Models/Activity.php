<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    public const CATEGORIES = [
        'kuliah' => 'Kuliah',
        'kerja' => 'Kerja',
        'pribadi' => 'Pribadi',
        'kesehatan' => 'Kesehatan',
        'lainnya' => 'Lainnya',
    ];

    public const PRIORITIES = [
        'rendah' => 'Rendah',
        'sedang' => 'Sedang',
        'tinggi' => 'Tinggi',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'category',
        'priority',
        'remind_at',
        'deadline_at',
        'is_done',
    ];

    protected $casts = [
        'is_done' => 'boolean',
        'deadline_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

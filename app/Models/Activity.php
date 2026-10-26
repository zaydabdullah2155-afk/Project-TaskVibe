<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['name', 'description', 'remind_at', 'is_done'];

    protected $casts = [
        'is_done' => 'boolean',
    ];
}
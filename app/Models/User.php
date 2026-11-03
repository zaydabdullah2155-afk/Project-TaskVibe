<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
        'exp',
        'streak_count',
        'last_active_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke tabel activities/tasks.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Fungsi untuk menambah XP dan naik level otomatis (tiap 100 XP naik 1 level).
     */
    public function addExp($amount)
    {
        $this->exp += $amount;
        $newLevel = floor($this->exp / 100) + 1;

        if ($newLevel > $this->level) {
            $this->level = $newLevel;
        }

        $this->save();
    }

    /**
     * Fungsi untuk mengelola Streak harian.
     */
    public function updateStreak()
    {
        $today = Carbon::today();
        $lastActive = $this->last_active_date ? Carbon::parse($this->last_active_date) : null;

        if (!$lastActive) {
            $this->streak_count = 1;
        } elseif ($lastActive->isYesterday()) {
            $this->streak_count += 1;
        } elseif ($lastActive->isToday()) {
            // Sudah dihitung hari ini, abaikan
        } else {
            $this->streak_count = 1; // Reset jika terlewat lebih dari 1 hari
        }

        $this->last_active_date = $today;
        $this->save();
    }
}
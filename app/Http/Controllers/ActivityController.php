<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $activities = $request->user()->activities()->orderBy('remind_at')->get();

        $total = $activities->count();
        $done = $activities->where('is_done', true)->count();

        return view('activities.index', compact('activities', 'total', 'done'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'remind_at' => 'required|date_format:H:i',
        ]);

        $request->user()->activities()->create($data);

        return redirect()->route('activities.index')
            ->with('success', 'Pengingat berhasil ditambahkan.');
    }

    public function edit(Activity $activity)
    {
        $this->ensureOwner($activity);

        return view('activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $this->ensureOwner($activity);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'remind_at' => 'required|date_format:H:i',
        ]);

        $activity->update($data);

        return redirect()->route('activities.index')
            ->with('success', 'Pengingat berhasil diperbarui.');
    }

    public function toggle(Activity $activity)
    {
        $this->ensureOwner($activity);

        // Ubah status selesai (jika tadinya belum selesai, kini jadi selesai)
        $newStatus = ! $activity->is_done;
        $activity->update(['is_done' => $newStatus]);

        // Jika aktivitas diubah menjadi selesai (true), berikan XP dan update Streak
        if ($newStatus) {
            $user = auth()->user();
            if ($user) {
                $user->updateStreak(); // Update streak harian (Ide 2)
                $user->addExp(20);     // Tambah 20 XP setiap tugas selesai (Ide 1)
            }
        }

        return redirect()->route('activities.index')
            ->with('success', $newStatus ? 'Aktivitas selesai! +20 XP ditambahkan.' : 'Status aktivitas diperbarui.');
    }

    public function destroy(Activity $activity)
    {
        $this->ensureOwner($activity);

        $activity->delete();

        return redirect()->route('activities.index')
            ->with('success', 'Pengingat dihapus.');
    }

    private function ensureOwner(Activity $activity): void
    {
        abort_unless($activity->user_id === auth()->id(), 403);
    }
}
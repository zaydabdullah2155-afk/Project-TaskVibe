<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(['pending', 'done'])],
            'category' => ['nullable', Rule::in(array_keys(Activity::CATEGORIES))],
            'priority' => ['nullable', Rule::in(array_keys(Activity::PRIORITIES))],
        ]);

        $baseQuery = $request->user()->activities();
        $total = (clone $baseQuery)->count();
        $done = (clone $baseQuery)->where('is_done', true)->count();
        $activities = (clone $baseQuery)
            ->when($filters['q'] ?? null, function (Builder $query, string $search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($filters['status'] ?? null, function (Builder $query, string $status): void {
                $query->where('is_done', $status === 'done');
            })
            ->when($filters['category'] ?? null, function (Builder $query, string $category): void {
                $query->where('category', $category);
            })
            ->when($filters['priority'] ?? null, function (Builder $query, string $priority): void {
                $query->where('priority', $priority);
            })
            ->orderBy('remind_at')
            ->get();
        $reminders = $request->user()->activities()
            ->where('is_done', false)
            ->get(['id', 'name', 'remind_at'])
            ->map(fn (Activity $activity): array => [
                'id' => $activity->id,
                'name' => $activity->name,
                'remindAt' => substr((string) $activity->remind_at, 0, 5),
            ])
            ->values();
        $chartEnd = now();
        $chartStart = $chartEnd->copy()->subDays(6)->startOfDay();
        $activityCounts = $request->user()->activities()
            ->where('is_done', true)
            ->whereNotNull('completed_at')
            ->whereBetween('completed_at', [$chartStart, $chartEnd])
            ->get(['completed_at'])
            ->countBy(fn (Activity $activity): string => $activity->completed_at->toDateString());
        $weekdayLabels = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $activityChart = collect(range(0, 6))
            ->map(function (int $daysFromStart) use ($activityCounts, $chartStart, $weekdayLabels): array {
                $date = $chartStart->copy()->addDays($daysFromStart);
                $weekday = $weekdayLabels[$date->dayOfWeek];

                return [
                    'date' => $date->format('d/m'),
                    'label' => "{$weekday} {$date->format('d/m')}",
                    'weekday' => $weekday,
                    'count' => $activityCounts->get($date->toDateString(), 0),
                ];
            })
            ->all();
        $maxActivityCount = max(array_column($activityChart, 'count'));
        $activityChartPoints = collect($activityChart)
            ->values()
            ->map(function (array $point, int $index) use ($maxActivityCount): array {
                $y = 140 - ($maxActivityCount > 0 ? ($point['count'] / $maxActivityCount) * 112 : 0);

                return $point + [
                    'x' => 50 + ($index * 100),
                    'y' => $y,
                    'countY' => max(14, $y - 12),
                ];
            })
            ->all();
        $activityChartLine = implode(' ', array_map(
            fn (array $point): string => "{$point['x']},{$point['y']}",
            $activityChartPoints,
        ));

        return view('activities.index', compact(
            'activities',
            'total',
            'done',
            'filters',
            'reminders',
            'activityChart',
            'activityChartPoints',
            'activityChartLine',
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => ['required', Rule::in(array_keys(Activity::CATEGORIES))],
            'priority' => ['required', Rule::in(array_keys(Activity::PRIORITIES))],
            'remind_at' => 'required|date_format:H:i',
            'deadline_at' => 'nullable|date|after:now',
        ]);

        $request->user()->activities()->create($data);

        return redirect()->route('activities.index')
            ->with('success', 'Pengingat berhasil ditambahkan.');
    }

    public function edit(Activity $activity): View
    {
        $this->ensureOwner($activity);

        return view('activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity): RedirectResponse
    {
        $this->ensureOwner($activity);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => ['required', Rule::in(array_keys(Activity::CATEGORIES))],
            'priority' => ['required', Rule::in(array_keys(Activity::PRIORITIES))],
            'remind_at' => 'required|date_format:H:i',
            'deadline_at' => 'nullable|date',
        ]);

        $activity->update($data);

        return redirect()->route('activities.index')
            ->with('success', 'Pengingat berhasil diperbarui.');
    }

    public function toggle(Activity $activity): RedirectResponse
    {
        $this->ensureOwner($activity);

        // Ubah status selesai (jika tadinya belum selesai, kini jadi selesai)
        $newStatus = ! $activity->is_done;
        $activity->is_done = $newStatus;
        $activity->completed_at = $newStatus ? now() : null;
        $activity->save();

        $message = 'Status aktivitas diperbarui.';

        // Jika aktivitas diubah menjadi selesai, berikan XP dan update streak
        if ($newStatus) {
            $user = auth()->user();

            if ($user) {
                // Tepat waktu = XP penuh, terlambat = XP kecil
                $isLate = $activity->deadline_at && now()->gt($activity->deadline_at);
                $xp = $isLate ? 5 : 20;

                $user->updateStreak();
                $user->addExp($xp);

                $message = $isLate
                    ? "Aktivitas selesai, tapi melewati deadline. +{$xp} XP ditambahkan."
                    : "Aktivitas selesai tepat waktu! +{$xp} XP ditambahkan.";
            }
        }

        return redirect()->route('activities.index')
            ->with('success', $message);
    }

    public function destroy(Activity $activity): RedirectResponse
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

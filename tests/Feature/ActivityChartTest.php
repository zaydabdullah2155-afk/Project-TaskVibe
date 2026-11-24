<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ActivityChartTest extends TestCase
{
    use RefreshDatabase;

    public function test_chart_shows_only_the_authenticated_users_completions_from_the_last_seven_days(): void
    {
        $this->travelTo(Carbon::parse('2026-11-24 18:00:00'));
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->createActivity($user, [
            'is_done' => true,
            'completed_at' => '2026-11-24 10:00:00',
        ]);
        $this->createActivity($user, [
            'is_done' => true,
            'completed_at' => '2026-11-24 11:00:00',
        ]);
        $this->createActivity($user, [
            'is_done' => true,
            'completed_at' => '2026-11-18 10:00:00',
        ]);
        $this->createActivity($user, [
            'is_done' => true,
            'completed_at' => '2026-11-17 10:00:00',
        ]);
        $this->createActivity($user, [
            'is_done' => false,
            'completed_at' => '2026-11-24 13:00:00',
        ]);
        $this->createActivity($otherUser, [
            'is_done' => true,
            'completed_at' => '2026-11-24 12:00:00',
        ]);

        $response = $this->actingAs($user)->get(route('activities.index'));

        $response->assertOk();
        $response->assertSee('Aktivitas Selesai - 7 Hari Terakhir');
        $response->assertSee('Sel 24/11: 2 aktivitas selesai', false);
        $response->assertSee('Rab 18/11: 1 aktivitas selesai', false);
        $response->assertSee('Min 22/11: 0 aktivitas selesai', false);
        $response->assertDontSee('Sel 17/11: 1 aktivitas selesai', false);
    }

    public function test_toggling_an_activity_records_and_clears_its_completion_timestamp(): void
    {
        $this->travelTo(Carbon::parse('2026-11-24 18:00:00'));
        $user = User::factory()->create();
        $activity = $this->createActivity($user, []);

        $this->actingAs($user)
            ->patch(route('activities.toggle', $activity))
            ->assertRedirect(route('activities.index', absolute: false));

        $this->assertSame(
            '2026-11-24 18:00:00',
            $activity->fresh()->completed_at->format('Y-m-d H:i:s'),
        );

        $this->patch(route('activities.toggle', $activity))
            ->assertRedirect(route('activities.index', absolute: false));

        $this->assertNull($activity->fresh()->completed_at);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function createActivity(User $user, array $attributes): Activity
    {
        $completedAt = $attributes['completed_at'] ?? null;
        unset($attributes['completed_at']);

        $activity = $user->activities()->create(array_merge([
            'name' => 'Aktivitas grafik',
            'remind_at' => '09:00:00',
        ], $attributes));

        if ($completedAt !== null) {
            $activity->forceFill(['completed_at' => $completedAt])->save();
        }

        return $activity;
    }
}

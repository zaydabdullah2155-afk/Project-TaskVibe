<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ActivityGamificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_completing_an_activity_awards_xp_and_starts_the_daily_streak(): void
    {
        $this->travelTo(Carbon::parse('2026-11-03 10:00:00'));
        $user = User::factory()->create([
            'exp' => 80,
            'level' => 1,
        ]);
        $activity = $this->createActivity($user);

        $response = $this->actingAs($user)
            ->patch(route('activities.toggle', $activity));

        $response->assertRedirect(route('activities.index', absolute: false));
        $response->assertSessionHas('success', 'Aktivitas selesai! +20 XP ditambahkan.');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'exp' => 100,
            'level' => 2,
            'streak_count' => 1,
        ]);
        $this->assertSame('2026-11-03', $user->fresh()->last_active_date->toDateString());
        $this->assertDatabaseHas('activities', [
            'id' => $activity->id,
            'is_done' => true,
            'xp_awarded' => true,
        ]);
        $this->assertNotNull($activity->fresh()->completed_at);
    }

    public function test_recompleting_an_already_rewarded_activity_extends_the_streak_without_extra_xp(): void
    {
        $this->travelTo(Carbon::parse('2026-11-04 10:00:00'));
        $user = User::factory()->create([
            'exp' => 20,
            'level' => 1,
            'streak_count' => 1,
            'last_active_date' => '2026-11-03',
        ]);
        $activity = $this->createActivity($user, [
            'xp_awarded' => true,
            'is_done' => false,
        ]);

        $response = $this->actingAs($user)
            ->patch(route('activities.toggle', $activity));

        $response->assertRedirect(route('activities.index', absolute: false));
        $response->assertSessionHas('success', 'Aktivitas selesai! XP sudah pernah diberikan.');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'exp' => 20,
            'streak_count' => 2,
        ]);
        $this->assertSame('2026-11-04', $user->fresh()->last_active_date->toDateString());
        $this->assertDatabaseHas('activities', [
            'id' => $activity->id,
            'is_done' => true,
            'xp_awarded' => true,
        ]);
    }

    public function test_completing_an_activity_after_a_missed_day_restarts_the_streak(): void
    {
        $this->travelTo(Carbon::parse('2026-11-05 10:00:00'));
        $user = User::factory()->create([
            'streak_count' => 4,
            'last_active_date' => '2026-11-02',
        ]);
        $activity = $this->createActivity($user);

        $response = $this->actingAs($user)
            ->patch(route('activities.toggle', $activity));

        $response->assertRedirect(route('activities.index', absolute: false));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'exp' => 20,
            'streak_count' => 1,
        ]);
        $this->assertSame('2026-11-05', $user->fresh()->last_active_date->toDateString());
    }

    public function test_another_user_cannot_complete_the_activity(): void
    {
        $owner = User::factory()->create();
        $activity = $this->createActivity($owner);
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)
            ->patch(route('activities.toggle', $activity));

        $response->assertForbidden();
        $this->assertDatabaseHas('activities', [
            'id' => $activity->id,
            'is_done' => false,
            'xp_awarded' => false,
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $owner->id,
            'exp' => 0,
            'streak_count' => 0,
        ]);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function createActivity(User $user, array $attributes = []): Activity
    {
        return $user->activities()->create(array_merge([
            'name' => 'Aktivitas uji',
            'remind_at' => '09:00:00',
        ], $attributes));
    }
}

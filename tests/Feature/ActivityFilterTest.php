<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_activity_can_be_created_with_a_category_and_priority(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('activities.store'), [
            'name' => 'Belajar Laravel',
            'description' => 'Selesaikan materi routing',
            'category' => 'kuliah',
            'priority' => 'tinggi',
            'remind_at' => '09:30',
        ]);

        $response->assertRedirect(route('activities.index', absolute: false));
        $this->assertDatabaseHas('activities', [
            'user_id' => $user->id,
            'name' => 'Belajar Laravel',
            'category' => 'kuliah',
            'priority' => 'tinggi',
        ]);
    }

    public function test_activity_list_can_be_filtered_by_search_status_category_and_priority(): void
    {
        $user = User::factory()->create();
        $matchingActivity = $this->createActivity($user, [
            'name' => 'Belajar Laravel',
            'description' => 'Routing untuk kuliah',
            'category' => 'kuliah',
            'priority' => 'tinggi',
            'is_done' => false,
        ]);
        $this->createActivity($user, [
            'name' => 'Belajar Vue',
            'category' => 'kuliah',
            'priority' => 'tinggi',
            'is_done' => true,
        ]);
        $this->createActivity($user, [
            'name' => 'Belajar React',
            'category' => 'kerja',
            'priority' => 'tinggi',
            'is_done' => false,
        ]);
        $this->createActivity($user, [
            'name' => 'Belajar Tailwind',
            'category' => 'kuliah',
            'priority' => 'rendah',
            'is_done' => false,
        ]);
        $this->createActivity($user, [
            'name' => 'Mencuci piring',
            'category' => 'pribadi',
            'priority' => 'rendah',
            'is_done' => false,
        ]);

        $response = $this->actingAs($user)->get(route('activities.index', [
            'q' => 'Belajar',
            'status' => 'pending',
            'category' => 'kuliah',
            'priority' => 'tinggi',
        ]));

        $response->assertOk();
        $response->assertSee($matchingActivity->name);
        $response->assertSee('1 ditampilkan / 5 total');
    }

    public function test_invalid_category_and_priority_are_rejected(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('activities.store'), [
            'name' => 'Aktivitas tidak valid',
            'category' => 'tidak-ada',
            'priority' => 'darurat',
            'remind_at' => '09:30',
        ]);

        $response->assertSessionHasErrors(['category', 'priority']);
        $this->assertDatabaseMissing('activities', [
            'user_id' => $user->id,
            'name' => 'Aktivitas tidak valid',
        ]);
    }

    public function test_activity_category_and_priority_can_be_updated(): void
    {
        $user = User::factory()->create();
        $activity = $this->createActivity($user, [
            'category' => 'pribadi',
            'priority' => 'sedang',
        ]);

        $response = $this->actingAs($user)->put(route('activities.update', $activity), [
            'name' => $activity->name,
            'description' => '',
            'category' => 'kerja',
            'priority' => 'rendah',
            'remind_at' => '09:00',
        ]);

        $response->assertRedirect(route('activities.index', absolute: false));
        $this->assertDatabaseHas('activities', [
            'id' => $activity->id,
            'category' => 'kerja',
            'priority' => 'rendah',
        ]);
    }

    public function test_dashboard_displays_browser_notification_controls(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('activities.index'));

        $response->assertOk();
        $response->assertSee('Notifikasi Browser');
        $response->assertSee('Aktifkan Notifikasi');
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function createActivity(User $user, array $attributes): Activity
    {
        return $user->activities()->create(array_merge([
            'name' => 'Aktivitas uji',
            'remind_at' => '09:00:00',
            'category' => 'lainnya',
            'priority' => 'sedang',
        ], $attributes));
    }
}

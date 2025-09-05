<?php

namespace Tests\Feature;

use App\Enums\TaskStatus;
use App\Http\Livewire\AuditLog;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class AuditLogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function audit_log_can_only_be_accessed_by_admin_users()
    {
        $regularUser = User::factory()->create(['is_admin' => false]);
        $adminUser = User::factory()->create(['is_admin' => true]);

        // Regular user should not be able to access audit log
        $this->actingAs($regularUser);
        $this->get('/audit-log')->assertForbidden();

        // Admin user should be able to access audit log
        $this->actingAs($adminUser);
        $this->get('/audit-log')->assertSuccessful();
    }

    /** @test */
    public function audit_log_component_can_be_rendered_by_admin()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        Livewire::test(AuditLog::class)
            ->assertStatus(200)
            ->assertSee('Audit Log')
            ->assertSee('Search activities...');
    }

    /** @test */
    public function it_displays_task_activities()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create(['name' => 'John Doe']);

        // Create a task which should log activity
        $task = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Test Task for Audit'
        ]);

        $this->actingAs($admin);

        Livewire::test(AuditLog::class)
            ->assertSee('Test Task for Audit')
            ->assertSee('Created')
            ->assertSee('System'); // Shows as System when causer is null
    }    /** @test */
    public function it_can_search_activities_by_description()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();

        $task1 = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Task One'
        ]);

        $task2 = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Task Two'
        ]);

        // Update one task to create an 'updated' activity
        $this->actingAs($user);
        $task1->update(['title' => 'Updated Task One']);

        $this->actingAs($admin);

        Livewire::test(AuditLog::class)
            ->set('search', 'updated')
            ->assertSee('Updated Task One')
            ->assertSee('updated')
            ->assertDontSee('Task Two');
    }

    /** @test */
    public function it_can_search_activities_by_subject_properties()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();

        $searchableTask = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Searchable Task'
        ]);

        $otherTask = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Other Task'
        ]);

        $this->actingAs($admin);

        Livewire::test(AuditLog::class)
            ->set('search', 'Searchable')
            ->assertSee('Searchable Task')
            ->assertDontSee('Other Task');
    }

    /** @test */
    public function it_paginates_activities()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();

        // Create many tasks to test pagination
        Task::factory()->count(25)->create(['user_id' => $user->id]);

        $this->actingAs($admin);

        $component = Livewire::test(AuditLog::class);

        // Should show pagination controls when there are more than 10 items
        $activities = Activity::paginate(10);
        if ($activities->hasPages()) {
            $component->assertSee('Next');
        }
    }

    /** @test */
    public function it_shows_activity_details()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create(['name' => 'John Doe']);

        $task = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Detailed Task',
            'description' => 'Task Description'
        ]);

        $this->actingAs($admin);

        Livewire::test(AuditLog::class)
            ->assertSee('Detailed Task')
            ->assertSee('Task Description')
            ->assertSee('System')
            ->assertSee('Created');
    }    /** @test */
    public function it_shows_empty_state_when_no_activities()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        // Clear all activities
        Activity::truncate();

        Livewire::test(AuditLog::class)
            ->assertSee('No activity logs found'); // Updated to match actual text
    }

    /** @test */
    public function it_shows_task_status_changes_in_activities()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();

        $task = Task::factory()->create([
            'user_id' => $user->id,
            'status' => TaskStatus::PENDING
        ]);

        // Update task status
        $this->actingAs($user);
        $task->update(['status' => TaskStatus::IN_PROGRESS]);

        $this->actingAs($admin);

        Livewire::test(AuditLog::class)
            ->assertSee('updated')
            ->assertSee($task->title);
    }

    /** @test */
    public function it_can_clear_search()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();

        Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Test Task'
        ]);

        $this->actingAs($admin);

        Livewire::test(AuditLog::class)
            ->set('search', 'nonexistent')
            ->assertDontSee('Test Task')
            ->set('search', '')
            ->assertSee('Test Task');
    }
}

<?php

namespace Tests\Unit;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_task()
    {
        $user = User::factory()->create();

        $task = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => TaskStatus::PENDING,
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => TaskStatus::PENDING->value,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $task->user);
        $this->assertEquals($user->id, $task->user->id);
    }

    /** @test */
    public function it_has_task_status_enum_cast()
    {
        $task = Task::factory()->create(['status' => TaskStatus::IN_PROGRESS]);

        $this->assertInstanceOf(TaskStatus::class, $task->status);
        $this->assertEquals(TaskStatus::IN_PROGRESS, $task->status);
    }

    /** @test */
    public function it_can_scope_tasks_by_status()
    {
        $user = User::factory()->create();

        Task::factory()->create(['user_id' => $user->id, 'status' => TaskStatus::PENDING]);
        Task::factory()->create(['user_id' => $user->id, 'status' => TaskStatus::IN_PROGRESS]);
        Task::factory()->create(['user_id' => $user->id, 'status' => TaskStatus::COMPLETED]);

        $pendingTasks = Task::ofStatus(TaskStatus::PENDING)->get();
        $inProgressTasks = Task::ofStatus(TaskStatus::IN_PROGRESS)->get();
        $completedTasks = Task::ofStatus(TaskStatus::COMPLETED)->get();

        $this->assertCount(1, $pendingTasks);
        $this->assertCount(1, $inProgressTasks);
        $this->assertCount(1, $completedTasks);
    }

    /** @test */
    public function it_can_scope_tasks_for_user()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Task::factory()->count(3)->create(['user_id' => $user1->id]);
        Task::factory()->count(2)->create(['user_id' => $user2->id]);

        $user1Tasks = Task::forUser($user1->id)->get();
        $user2Tasks = Task::forUser($user2->id)->get();

        $this->assertCount(3, $user1Tasks);
        $this->assertCount(2, $user2Tasks);
    }

    /** @test */
    public function it_can_order_tasks_by_sort_order()
    {
        $user = User::factory()->create();

        $task1 = Task::factory()->create(['user_id' => $user->id, 'sort_order' => 3]);
        $task2 = Task::factory()->create(['user_id' => $user->id, 'sort_order' => 1]);
        $task3 = Task::factory()->create(['user_id' => $user->id, 'sort_order' => 2]);

        $orderedTasks = Task::ordered()->get();

        $this->assertEquals($task2->id, $orderedTasks->first()->id);
        $this->assertEquals($task1->id, $orderedTasks->last()->id);
    }

    /** @test */
    public function it_logs_activity_when_created()
    {
        $user = User::factory()->create();

        $task = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'New Task',
        ]);

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => Task::class,
            'subject_id' => $task->id,
            'description' => 'Task created: New Task',
            'causer_id' => null, // causer_id is null when created via factory
        ]);
    }

    /** @test */
    public function it_logs_activity_when_updated()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $task->update(['title' => 'Updated Title']);

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => Task::class,
            'subject_id' => $task->id,
            'description' => 'Task updated: Updated Title',
            'causer_id' => $user->id,
        ]);
    }
}

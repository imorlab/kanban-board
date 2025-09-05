<?php

namespace Tests\Feature;

use App\Enums\TaskStatus;
use App\Http\Livewire\CreateTaskForm;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTaskFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function create_task_form_can_be_rendered()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(CreateTaskForm::class)
            ->assertStatus(200)
            ->assertSet('title', '')
            ->assertSet('description', '')
            ->assertSet('status', TaskStatus::PENDING->value);
    }

    /** @test */
    public function it_can_create_new_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(CreateTaskForm::class)
            ->set('title', 'New Test Task')
            ->set('description', 'Test description')
            ->call('createTask')
            ->assertSet('title', '')
            ->assertSet('description', '')
            ->assertEmitted('taskCreated');

        $this->assertDatabaseHas('tasks', [
            'title' => 'New Test Task',
            'description' => 'Test description',
            'status' => TaskStatus::PENDING->value,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function it_validates_required_fields_when_creating_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(CreateTaskForm::class)
            ->set('title', '')
            ->set('description', '')
            ->call('createTask')
            ->assertHasErrors(['title' => 'required'])
            ->assertHasNoErrors(['description']);
    }

    /** @test */
    public function it_can_set_different_status()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(CreateTaskForm::class)
            ->set('title', 'In Progress Task')
            ->set('status', TaskStatus::IN_PROGRESS->value)
            ->call('createTask');

        $this->assertDatabaseHas('tasks', [
            'title' => 'In Progress Task',
            'status' => TaskStatus::IN_PROGRESS->value,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function it_validates_status_field()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(CreateTaskForm::class)
            ->set('title', 'Test Task')
            ->set('status', 'invalid_status')
            ->call('createTask')
            ->assertHasErrors(['status']);
    }

    /** @test */
    public function it_can_close_form()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(CreateTaskForm::class)
            ->set('title', 'Some title')
            ->set('description', 'Some description')
            ->call('closeForm')
            ->assertSet('title', '')
            ->assertSet('description', '')
            ->assertSet('status', TaskStatus::PENDING->value)
            ->assertEmitted('taskCreated');
    }
}

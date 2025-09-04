<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a demo user if it doesn't exist
        $demoUser = User::firstOrCreate([
            'email' => 'demo@kanban.com'
        ], [
            'name' => 'Demo User',
            'password' => bcrypt('password'),
        ]);

        // Create sample tasks for the demo user
        // Pending tasks
        for ($i = 1; $i <= 3; $i++) {
            Task::factory()->pending()->create([
                'user_id' => $demoUser->id,
                'sort_order' => $i,
            ]);
        }

        // In progress tasks
        for ($i = 1; $i <= 2; $i++) {
            Task::factory()->inProgress()->create([
                'user_id' => $demoUser->id,
                'sort_order' => $i,
            ]);
        }

        // Completed tasks
        for ($i = 1; $i <= 4; $i++) {
            Task::factory()->completed()->create([
                'user_id' => $demoUser->id,
                'sort_order' => $i,
            ]);
        }
    }
}

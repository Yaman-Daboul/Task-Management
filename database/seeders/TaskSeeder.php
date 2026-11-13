<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            ['title' => 'Working', 'description' => 'something usefull', 'priority' => 1],
            ['title' => 'playing', 'description' => 'Football', 'priority' => 1],
            ['title' => 'reading', 'description' => 'A book', 'priority' => 5],
            ['title' => 'swimming', 'description' => 'In my own pool', 'priority' => 4],
            ['title' => 'learning', 'description' => 'Laravel', 'priority' => 3],
            ['title' => 'watching', 'description' => 'A romantic Film', 'priority' => 2],
            ['title' => 'sleep', 'description' => '8 hours', 'priority' => 1],
        ];

        foreach ($tasks as $task) {
            Task::create([
                'title' => $task['title'],
                'description' => $task['description'],
                'priority' => $task['priority'],
                'user_id' => 1,
            ]);
        }
    }
}

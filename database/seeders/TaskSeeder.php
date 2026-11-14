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
        Task::factory()->count(20)->create();
        // $tasks = [
        //     ['title' => 'Working', 'description' => 'something usefull', 'priority' => 1],
        //     ['title' => 'playing', 'description' => 'Football', 'priority' => 1],
        //     ['title' => 'reading', 'description' => 'A book', 'priority' => 5],
        //     ['title' => 'swimming', 'description' => 'In my own pool', 'priority' => 4],
        //     ['title' => 'learning', 'description' => 'Laravel', 'priority' => 3],
        //     ['title' => 'watching', 'description' => 'A romantic Film', 'priority' => 2],
        //     ['title' => 'sleep', 'description' => '8 hours', 'priority' => 1],
        // ];

        // foreach ($tasks as $task) {
        //     Task::create([
        //         'title' => $task['title'],
        //         'description' => $task['description'],
        //         'priority' => $task['priority'],
        //         'user_id' => 1,
        //     ]);
        // }

        // • استخدم الـ Seeder مباشرة (بدون Factory) عندما:
        // 	• تريد إدخال بيانات حقيقية وثابتة يحتاجها النظام ليعمل، مثل:
        // 	• حساب المدير الرئيسي (admin@example.com) بكلمة مرور معروفة لتتمكن من تسجيل الدخول.
        // 	• قائمة الدول، المدن، أو الأقسام الثابتة في النظام (مثل: عمل، شخصي، دراسة).
        // 	• تريد تنسيق الترتيب بين عدة جداول (مثلاً: إنشاء 10 مستخدمين، ثم إنشاء 5 مهام لكل مستخدم).

    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Modules\Blog\Models\Blog;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $user = User::where('email', 'yepansh001@gmail.com')->first();
        for ($i = 1; $i <= 100; $i++) {
            $user->blogs()->create([
                'title' => 'Blog Title ' . $i,
                'blog_body' => 'Blog Body Text for Blog ' . $i
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Modules\Blog\Models\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        $user = User::factory()->create([
            'name' => 'Ansh Suman',
            'email' => 'ansh@capitalnumbers.com',
            'password' => Hash::make(12345678)
        ]);

        for ($i = 1; $i <= 100; $i++) {
            $user->blogs()->create([
                'title' => 'Blog Title ' . $i,
                'blog_body' => 'Blog Body Text for Blog ' . $i
            ]);
        }
    }
}
